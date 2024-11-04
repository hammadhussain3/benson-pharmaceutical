<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Employee;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Company;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Services\EmployeeService;
use App\Services\CompanyService;
use App\Services\RoleService;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */

    protected $employeeService;
    protected $companyService;
    protected $roleService;

    public function __construct(EmployeeService $employeeService, CompanyService $companyService, RoleService $roleService)
    {
        $this->employeeService = $employeeService;
        $this->companyService = $companyService;
        $this->roleService = $roleService;
    }

    public function index(): View
    {
        $usersQuery = User::with('roles', 'employee')
            ->where('id', '!=', 1) // Exclude user with ID 1 if needed
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'Superadmin');
            })
            ->orderBy('name', 'asc');

        if (auth()->user()->hasRole('Superadmin')) {
            $users = $usersQuery->get();
        } else {
            $users = $usersQuery->where('id', '!=', auth()->id())
            ->whereHas('employee', function ($query) {
                $query->where('company_id', auth()->user()->employee->company_id);
            })->get();
        }
        return view('auth.index', compact('users'));
    }

    public function view($id)
    {
        $user =  User::findOrFail($id);
        return view('auth.view', compact('user'));
    }

    public function create(): View
    {
        $roles = $this->roleService->getAllRoles();
        $companies = $this->companyService->getAllCompanies();
        if (auth()->user()->hasRole('Superadmin')) {
            $employees = $this->employeeService->getAllEmployees();
        } else {
            $employees = $this->employeeService->getAllEmployees()->where('id', '!=', auth()->user()->employee_id)->where('company_id', auth()->user()->employee->company_id);
        }

        return view('auth.register', compact('roles', 'companies', 'employees'));
    }
    public function edit($id)
    {
        // Fetch the user by the ID with roles and employee relationships
        $user = User::with('roles', 'employee')->findOrFail($id);
        if (auth()->user()->hasRole('Superadmin')) {
            $employees = $this->employeeService->getAllEmployees()->where('company_id', $user->employee->company_id);
        } else {
            $employees = $this->employeeService->getAllEmployees()->where('id', '!=', auth()->user()->employee_id)->where('company_id', auth()->user()->employee->company_id);
        }
        $employee_details = Employee::where('id', $user->employee_id)->first();
        $roles = $this->roleService->getAllRoles();
        $companies = $this->companyService->getAllCompanies();
        $branch = Branch::where('id', $user->employee->branch_id)->value('name');
        $department = Department::where('id', $user->employee->department_id)->value('name');
        $designation = Designation::where('id', $user->employee->designation_id)->value('name');
    
        // Return the edit view with the user, employees, and roles data
        return view('auth.edit', compact('user', 'employees', 'roles', 'companies', 'employee_details', 'branch', 'department', 'designation'));
    }
    


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'user' => ['required', 'integer', 'unique:users,employee_id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required'],
            'role' => ['required', 'exists:roles,id'],
        ]);

        $user = User::create([
            'employee_id' => $request->user,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Attach the single role to the user
        $user->roles()->attach($request->role);

        // event(new Registered($user));

        return redirect()->route('users.index')->with('success', 'User Created successfully.');
    }
    public function update(Request $request, $id): RedirectResponse
    {
        // Validate the incoming request
        $request->validate([
            'user' => ['required', 'integer', 'unique:users,employee_id,' . $id],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $id], // Ignore current user's email for uniqueness
            'password' => ['nullable'],
            'role' => ['required', 'exists:roles,id'],
        ]);
    
        // Find the user by ID
        $user = User::findOrFail($id);
    
        // Update the user's basic details
        $user->update([
            'employee_id' => $request->user,
            'name' => $request->name,
            'email' => $request->email,
        ]);
    
        // Only update the password if a new one is provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save(); // Save the user after password change
        }
    
        // Sync the role to ensure only one role is assigned at a time
        $user->roles()->sync([$request->role]);
    
        // Return a redirect with a success message
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
    

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully along with their roles.');
    }
}