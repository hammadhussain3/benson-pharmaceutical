<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalarySlipRequest;
use App\Models\SalarySlip;
use App\Models\Employee;
use App\Models\Company;
use App\Services\SalarySlipService;
use Illuminate\Http\Request;
use App\Models\Loan;

class SalarySlipController extends Controller
{
    protected $salarySlipService;

    public function __construct(SalarySlipService $salarySlipService)
    {
        $this->salarySlipService = $salarySlipService;
    }

    public function index()
    {
        $salarySlips = SalarySlip::with(['employee', 'company'])->get();
        return view('admin.salary_slips.index', compact('salarySlips'));
    }

    public function create()
    {

        $employees = Employee::all();
        $companies = Company::all();

        return view('admin.salary_slips.create', compact('employees', 'companies'));
    }

    public function store(SalarySlipRequest $request)
    {
        $this->salarySlipService->createSalarySlip($request->validated());
        return redirect()->route('salary_slips.index')->with('success', 'Salary Slip created successfully.');
    }

    public function edit($id)
    {
        $salarySlip = SalarySlip::findOrFail($id);


        $employees = Employee::all();
        $companies = Company::all();

        return view('admin.salary_slips.edit', compact('salarySlip', 'employees', 'companies'));
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
