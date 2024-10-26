<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalarySlipRequest;
use App\Models\SalarySlip;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Services\SalarySlipService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use App\Models\Loan;

class SalarySlipController extends Controller
{
    protected $salarySlipService;
    protected $employeeService;

    public function __construct(SalarySlipService $salarySlipService, EmployeeService $employeeService)
    {
        $this->salarySlipService = $salarySlipService;
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        $salarySlips = SalarySlip::with(['employee', 'company'])->get();
        return view('admin.salary_slips.index', compact('salarySlips'));
    }

    public function create()
    {

        $employees = $this->employeeService->getAllEmployees();
        $companies = Company::all();
        $branches = Branch::all();
        $departments = Department::all();
        $designations = Designation::all();

        return view('admin.salary_slips.create', compact('employees', 'companies', 'branches', 'departments', 'designations'));
    }

    public function store(SalarySlipRequest $request)
    {
        $this->salarySlipService->createSalarySlip($request->validated());
        return redirect()->route('salary_slips.index')->with('success', 'Salary Slip created successfully.');
    }

    public function edit($id)
    {
        $salarySlip = SalarySlip::findOrFail($id);

        $currentEmployee = Employee::findOrFail($salarySlip->employee_id);
        $employees = $this->employeeService->getAllEmployees();
        $companies = Company::all();
        $branches = Branch::all();
        $departments = Department::all();
        $designations = Designation::all();

        return view('admin.salary_slips.edit', compact('salarySlip', 'currentEmployee', 'employees', 'companies', 'branches', 'departments', 'designations'));
    }

    public function update(SalarySlipRequest $request, $id)
    {
        $salarySlip = SalarySlip::findOrFail($id);
        $this->salarySlipService->updateSalarySlip($salarySlip, $request->validated());
        return redirect()->route('salary_slips.index')->with('success', 'Salary Slip updated successfully.');
    }

    public function destroy($id)
    {
        $salarySlip = SalarySlip::findOrFail($id);
        $salarySlip->delete();
        return redirect()->route('salary_slips.index')->with('success', 'Salary Slip deleted successfully.');
    }
}
