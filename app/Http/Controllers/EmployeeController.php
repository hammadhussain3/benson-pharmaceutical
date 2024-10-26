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
use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        $employees = $this->employeeService->getAllEmployees();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $lastEmployeeCode = Employee::latest('id')->value('code');
        if ($lastEmployeeCode) {
            $numberPart = (int) substr($lastEmployeeCode, 3);
            $newNumberPart = $numberPart + 1;
            $newEmployeeCode = 'EMP' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newEmployeeCode = 'EMP00001';
        }
        $designations = Designation::all();
        $departments = Department::all();
        $banks = Bank::all();
        $branches = Branch::all();
        $companies = Company::all();

        return view('admin.employees.create', compact('designations', 'departments', 'banks', 'branches', 'companies', 'newEmployeeCode'));
    }

    public function edit(Employee $employee)
    {
        $designations = Designation::all();
        $departments = Department::all();
        $banks = Bank::all();
        $branches = Branch::all();
        $companies = Company::all();

        return view('admin.employees.edit', compact('employee', 'designations', 'departments', 'banks', 'branches', 'companies'));
    }
    public function store(StoreEmployeeRequest $request)
    {
        $this->employeeService->createEmployee($request->validated());
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function getCompanyByEmployee($employeeId)
    {
        // Fetch the loan record for the given employee ID
        $company = Employee::where('id', $employeeId)->value('company_id');

        return response()->json(['company' => $company]);
    }

    public function getEmployeeDetails($employeeId)
    {
        // Fetch the loan record for the given employee ID
        $employee = Employee::findOrFail($employeeId);

        return response()->json([
            'branch' => $employee->branch_id,
            'department' => $employee->department_id,
            'designation' => $employee->designation_id,
            'basic_pay' => $employee->basic_pay,
            'allowances' => $employee->allowances,
            'date_of_joining' => $employee->date_of_joining,
        ]);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $this->employeeService->updateEmployee($employee, $request->validated());
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $this->employeeService->deleteEmployee($employee);
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
