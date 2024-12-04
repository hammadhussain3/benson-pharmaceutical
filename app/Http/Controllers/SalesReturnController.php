<?php

namespace App\Http\Controllers;

use App\Models\SalesReturn;
use App\Http\Requests\SalesReturnRequest;
use App\Services\ProductVariationService;
use App\Services\SalesReturnService;
use App\Services\FranchiseService;
use App\Services\CompanyService;
use App\Services\BatchService;

class SalesReturnController extends Controller
{
    protected $productVariationService;
    protected $salesReturnService;
    protected $franchiseService;
    protected $companyService;
    protected $batchService;

    public function __construct(SalesReturnService $salesReturnService, ProductVariationService $productVariationService, CompanyService $companyService, FranchiseService $franchiseService, BatchService $batchService)
    {
        $this->productVariationService = $productVariationService;
        $this->salesReturnService = $salesReturnService;
        $this->franchiseService = $franchiseService;
        $this->companyService = $companyService;
        $this->batchService = $batchService;
    }

    public function index()
    {
        $salesReturns = $this->salesReturnService->getAll();
        return view('admin.sales-returns.index', compact('salesReturns'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $newSalesReturnCode = "SR";
        } else {
            $newSalesReturnCode = $this->salesReturnService->createCode(auth()->user()->employee->company_id);
        }
        $companies = $this->companyService->getAllCompanies();
        $franchisers = $this->franchiseService->getAllFranchises();
        $productVariations = $this->productVariationService->getAllProductVariations();
        $batches = $this->batchService->getAllBatches();
        return view('admin.sales-returns.create', compact('companies', 'franchisers', 'productVariations', 'batches', 'newSalesReturnCode'));
    }

    public function store(SalesReturnRequest $request)
    {
        $this->salesReturnService->create($request->validated());
        return redirect()->route('sales-returns.index')->with('success', 'Sales Return created successfully.');
    }

    public function show($id)
    {
        $salesReturn = $this->salesReturnService->getById($id);
        return view('admin.sales-returns.show', compact('salesReturn'));
    }

    public function edit($id)
    {
        $salesReturn = $this->salesReturnService->getById($id);
        return view('admin.sales-returns.edit', compact('salesReturn'));
    }

    public function update(SalesReturnRequest $request, SalesReturn $salesReturn)
    {
        $this->salesReturnService->update($salesReturn, $request->validated());
        return redirect()->route('sales-returns.index')->with('success', 'Sales Return updated successfully');
    }

    public function destroy(SalesReturn $salesReturn)
    {
        $this->salesReturnService->delete($salesReturn);
        return redirect()->route('sales-returns.index')->with('success', 'Sales Return deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $sales_return_code = $this->salesReturnService->createCode($companyId);
        return response()->json(['sales_return_code' => $sales_return_code]);
    }
}
