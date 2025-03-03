<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\SalarySlip;
use App\Services\EmployeeService;
use App\Services\EmployeeTypeService;

class EmployeeController extends Controller
{
    protected $employeeService;
    protected $employeeTypeService;

    public function __construct(EmployeeService $employeeService, EmployeeTypeService $employeeTypeService)
    {
        $this->employeeService = $employeeService;
        $this->employeeTypeService = $employeeTypeService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Employee List')) {
            abort(403, 'Unauthorized action.');
        }
        $employees = $this->employeeService->getAllEmployees();
        return view('admin.employees.index', compact('employees'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('Employee View')) {
            abort(403, 'Unauthorized action.');
        }
        $employees =  $this->employeeService->getemployeeById($id);
        return view('admin.employees.view', compact('employees'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Employee Create')) {
            abort(403, 'Unauthorized action.');
        }
        if (auth()->user()->hasRole('Superadmin')) {
            $newEmployeeCode = "EMP";
        } else {
            $newEmployeeCode = $this->employeeService->createEmployeeCode(auth()->user()->employee->company_id);
        }
        $banks = Bank::orderBy('name', 'asc')->get();
        $companies = Company::orderBy('name', 'asc')->get();
        $branches = Branch::orderBy('name', 'asc')->get();
        $departments = Department::orderBy('name', 'asc')->get();
        $designations = Designation::orderBy('name', 'asc')->get();
        $employeeTypes = $this->employeeTypeService->getAllEmployeeTypes();

        if (!auth()->user()->hasRole('Superadmin')) {
            $branches = Branch::orderBy('name', 'asc')->where('company_id', auth()->user()->employee->company_id)->get();
            $departments = Department::orderBy('name', 'asc')->where('company_id', auth()->user()->employee->company_id)->get();
            $designations = Designation::orderBy('name', 'asc')->where('company_id', auth()->user()->employee->company_id)->get();
        }

        return view('admin.employees.create', compact('designations', 'departments', 'banks', 'branches', 'companies', 'newEmployeeCode', 'employeeTypes'));
    }

    public function edit(Employee $employee)
    {
        if (!auth()->user()->hasPermission('Employee Update')) {
            abort(403, 'Unauthorized action.');
        }
        $designations = Designation::orderBy('name', 'asc')->get();
        $banks = Bank::orderBy('name', 'asc')->get();
        $companies = Company::orderBy('name', 'asc')->get();
        $branches = Branch::orderBy('name', 'asc')->get();
        $departments = Department::orderBy('name', 'asc')->get();
        $designations = Designation::orderBy('name', 'asc')->get();
        $employeeTypes = $this->employeeTypeService->getAllEmployeeTypes();

        return view('admin.employees.edit', compact('employee', 'designations', 'departments', 'banks', 'branches', 'companies', 'employeeTypes'));
    }
    public function store(StoreEmployeeRequest $request)
    {
        if (!auth()->user()->hasPermission('Employee Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->employeeService->createEmployee($request->validated());
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        if (!auth()->user()->hasPermission('Employee Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->employeeService->updateEmployee($employee, $request->validated());
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        if (!auth()->user()->hasPermission('Employee Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->employeeService->deleteEmployee($employee);
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function getCompanyByEmployee($employeeId)
    {
        // Fetch the loan record for the given employee ID
        $company_id = Employee::where('id', $employeeId)->value('company_id');
        $company = Company::findOrFail($company_id);

        return response()->json(['company_id' => $company_id, 'company' => $company->name]);
    }

    public function getEmployeeDetails($employeeId)
    {
        // Fetch the loan record for the given employee ID
        $employee = Employee::findOrFail($employeeId);
        $branch = Branch::findOrFail($employee->branch_id);
        $department = Department::findOrFail($employee->department_id);
        $designation = Designation::findOrFail($employee->designation_id);
        $salary = SalarySlip::where('employee_id', $employeeId)->latest()->value('income');

        return response()->json([
            'code' => $employee->code,
            'first_name' => $employee->first_name,
            'last_name' => $employee->last_name,
            'email' => $employee->email,
            'branch_id' => $employee->branch_id,
            'department_id' => $employee->department_id,
            'designation_id' => $employee->designation_id,
            'branch' => $branch->name,
            'department' => $department->name,
            'designation' => $designation->name,
            'basic_pay' => $salary == 0 ? $employee->basic_pay : $salary,
            'allowances' => $employee->allowances,
            'date_of_joining' => $employee->date_of_joining,
        ]);
    }

    public function getEmployeesByCompany($companyId)
    {
        $employees = Employee::where('company_id', $companyId)->get();
        return response()->json(['employees' => $employees]);
    }

    public function createCodeByCompany($companyId)
    {
        $employee_code = $this->employeeService->createEmployeeCode($companyId);
        return response()->json(['employee_code' => $employee_code]);
    }
}