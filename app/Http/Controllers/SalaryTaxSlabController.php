<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryTaxSlabRequest;
use App\Models\Company; // Include Company model
use App\Models\SalaryTaxSlab;
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
