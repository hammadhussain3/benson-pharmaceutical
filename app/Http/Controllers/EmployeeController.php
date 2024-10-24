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
        $designations = Designation::all();
        $departments = Department::all();
        $banks = Bank::all();
        $branches = Branch::all();
        $companies = Company::all();

        return view('admin.employees.create', compact('designations', 'departments', 'banks', 'branches', 'companies'));
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
