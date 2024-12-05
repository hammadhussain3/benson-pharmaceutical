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
        if (!auth()->user()->hasPermission('Sales Return List')) {
            abort(403, 'Unauthorized action.');
        }
        $salesReturns = $this->salesReturnService->getAll();
        return view('admin.sales-returns.index', compact('salesReturns'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Sales Return Create')) {
            abort(403, 'Unauthorized action.');
        }
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
        if (!auth()->user()->hasPermission('Sales Return Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->salesReturnService->create($request->validated());
        return redirect()->route('sales-returns.index')->with('success', 'Sales Return created successfully.');
    }

    public function show($id)
    {
        if (!auth()->user()->hasPermission('Sales Return View')) {
            abort(403, 'Unauthorized action.');
        }
        $salesReturn = $this->salesReturnService->getById($id);
        return view('admin.sales-returns.show', compact('salesReturn'));
    }

    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Sales Return Update')) {
            abort(403, 'Unauthorized action.');
        }
        $salesReturn = $this->salesReturnService->getById($id);
        $companies = $this->companyService->getAllCompanies();
        $franchisers = $this->franchiseService->getAllFranchises();
        $productVariations = $this->productVariationService->getAllProductVariations();
        $batches = $this->batchService->getAllBatches();
        return view('admin.sales-returns.edit', compact('salesReturn', 'companies', 'franchisers', 'productVariations', 'batches'));
    }

    public function update(SalesReturnRequest $request, SalesReturn $salesReturn)
    {
        if (!auth()->user()->hasPermission('Sales Return Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->salesReturnService->update($salesReturn, $request->validated());
        return redirect()->route('sales-returns.index')->with('success', 'Sales Return updated successfully');
    }

    public function destroy(SalesReturn $salesReturn)
    {
        if (!auth()->user()->hasPermission('Sales Return Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->salesReturnService->delete($salesReturn);
        return redirect()->route('sales-returns.index')->with('success', 'Sales Return deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $sales_return_code = $this->salesReturnService->createCode($companyId);
        return response()->json(['sales_return_code' => $sales_return_code]);
    }
}
