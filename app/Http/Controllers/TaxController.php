<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Http\Requests\TaxRequest;
use App\Services\TaxService;
use App\Services\CompanyService;

class TaxController extends Controller
{
    protected $companyService;
    protected $taxService;

    public function __construct(TaxService $taxService, CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->taxService = $taxService;
    }

    public function index()
    {
        $taxes = $this->taxService->getAllTaxes();
        return view('admin.taxes.index', compact('taxes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = $this->companyService->getAllCompanies();
        return view('admin.taxes.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaxRequest $request)
    {
        $this->taxService->createTax($request->validated());
        return redirect()->route('taxes.index')->with('success', 'Tax created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tax = $this->taxService->getTaxById($id);
        return view('admin.taxes.show', compact('tax'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tax = $this->taxService->getTaxById($id);
        $companies = $this->companyService->getAllCompanies();
        return view('admin.taxes.edit', compact('tax', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaxRequest $request, Tax $tax)
    {
        $this->taxService->updateTax($tax, $request->validated());
        return redirect()->route('taxes.index')->with('success', 'Tax updated successfully');
    }

    public function destroy(Tax $tax)
    {
        $this->taxService->deleteTax($tax);
        return redirect()->route('taxes.index')->with('success', 'Tax deleted successfully');
    }
}
