<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryTaxSlabRequest;
use App\Models\Company;
use App\Models\SalaryTaxSlab;
use App\Models\Employee;
use App\Services\SalaryTaxSlabService;

class SalaryTaxSlabController extends Controller
{
    protected $service;

    public function __construct(SalaryTaxSlabService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $taxSlabs = $this->service->getAllSlabs();
        return view('admin.salary_tax_slabs.index', compact('taxSlabs'));
    }

    public function view($id)
    {
        $taxSlabs =  $this->service->getSlabById($id);
        return view('admin.salary_tax_slabs.view', compact('taxSlabs'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('admin.salary_tax_slabs.create', compact('companies'));
    }

    public function store(SalaryTaxSlabRequest $request)
    {
        $this->service->createSlab($request->validated());
        return redirect()->route('tax-slabs.index')->with('success', 'Salary Tax Slab created successfully');
    }

    public function edit($id)
    {
        $taxSlab = SalaryTaxSlab::findOrFail($id);
        $companies = Company::all();
        return view('admin.salary_tax_slabs.edit', compact('taxSlab', 'companies'));
    }

    public function getIncomeTaxByEmployee($employeeId)
    {
        // Fetch the basic pay for the given employee ID
        $employee = Employee::where('id', $employeeId)->first();

        $employee_salary = 12 * ($employee->basic_pay + $employee->allowances);
        // Fetch the tax value based on the employee's basic pay and company ID
        $taxRate = SalaryTaxSlab::where('company_id', $employee->company_id)
        ->where('slab_start', '<=', $employee_salary)
        ->where(function ($query) use ($employee_salary) {
            $query->where('slab_end', '>=', $employee_salary)
                ->orWhereNull('slab_end'); // For open-ended slabs
        })
        ->value('tax_value') ?? 0;

        $incomeTax = ($employee->basic_pay + $employee->allowances) * ($taxRate / 100);

        // Return 0 if no matching slab is found
        $incomeTax = $incomeTax ?? 0;

        return response()->json(['incomeTax' => $incomeTax]);
    }


    public function update(SalaryTaxSlabRequest $request, $id)
    {
        $taxSlab = SalaryTaxSlab::findOrFail($id);
        $this->service->updateSlab($taxSlab, $request->validated());
        return redirect()->route('tax-slabs.index')->with('success', 'Salary Tax Slab updated successfully');
    }


    public function destroy($id)
    {
        $taxSlab = SalaryTaxSlab::findOrFail($id);
        $this->service->deleteSlab($taxSlab);
        return redirect()->route('tax-slabs.index')->with('success', 'Salary Tax Slab deleted successfully');
    }
}