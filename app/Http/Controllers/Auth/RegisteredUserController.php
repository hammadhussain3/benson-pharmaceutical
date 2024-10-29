<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Employee;
use App\Models\Branch;
use App\Models\Company;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Services\EmployeeService;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */

    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index(): View
    {
        $users = User::with('roles', 'employee')->where('id', '!=', '1')->orderBy('name', 'asc')->get();
        // $company = Company::find($users->company_id);
        // $branch = Branch::find($users->company_id);
        // echo '<pre>';
        // print_r($users);
        // exit;
        return view('auth.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Role::orderBy('name', 'asc')->get();
        $employees = $this->employeeService->getAllEmployees();

        return view('auth.register', compact('roles', 'employees'));
    }
    public function edit($id)
    {
        // Fetch the user by the ID with roles and employee relationships
        $user = User::with('roles', 'employee')->findOrFail($id);
    
        // Fetch all employees and roles for the dropdowns
        $employees = Employee::all();
        $roles = Role::all();
    
        // Return the edit view with the user, employees, and roles data
        return view('auth.edit', compact('user', 'employees', 'roles'));
    }
    


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,id'],
        ]);

        $user = User::create([
            'employee_id' => $request->employee_id,
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
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $id], // Ignore current user's email for uniqueness
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,id'],
        ]);
    
        // Find the user by ID
        $user = User::findOrFail($id);
    
        // Update the user's basic details
        $user->update([
            'employee_id' => $request->employee_id,
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