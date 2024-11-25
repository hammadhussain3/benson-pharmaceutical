<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequisition;
use App\Http\Requests\PurchaseRequisitionRequest;
use App\Services\PurchaseRequisitionService;
use App\Services\CompanyService;
use App\Services\SupplierService;

class PurchaseRequisitionController extends Controller
{
    protected $companyService;
    protected $purchaseRequisitionService;
    protected $supplierService;

    public function __construct(PurchaseRequisitionService $purchaseRequisitionService, CompanyService $companyService, SupplierService $supplierService)
    {
        $this->companyService = $companyService;
        $this->purchaseRequisitionService = $purchaseRequisitionService;
        $this->supplierService = $supplierService;
    }

    public function index()
    {
        $purchaseRequisitions = $this->purchaseRequisitionService->getAllPurchaseRequisitions();
        return view('admin.purchase-requisitions.index', compact('purchaseRequisitions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $newPurchaseRequisitionCode = "MPR";
        } else {
            $newPurchaseRequisitionCode = $this->purchaseRequisitionService->createPurchaseRequisitionCode(auth()->user()->employee->company_id);
        }
        $companies = $this->companyService->getAllCompanies();
        $suppliers = $this->supplierService->getAllSuppliers();
        return view('admin.purchase-requisitions.create', compact('companies', 'suppliers', 'newPurchaseRequisitionCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PurchaseRequisitionRequest $request)
    {
        $this->purchaseRequisitionService->createPurchaseRequisition($request->validated());
        return redirect()->route('purchase-requisitions.index')->with('success', 'Purchase Requisition created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $purchaseRequisition = $this->purchaseRequisitionService->getPurchaseRequisitionById($id);
        return view('admin.purchase-requisitions.show', compact('purchaseRequisition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $purchaseRequisition = $this->purchaseRequisitionService->getPurchaseRequisitionById($id);
        $companies = $this->companyService->getAllCompanies();
        $suppliers = $this->supplierService->getAllSuppliers();
        return view('admin.purchase-requisitions.edit', compact('purchaseRequisition', 'companies', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PurchaseRequisitionRequest $request, PurchaseRequisition $purchaseRequisition)
    {
        $this->purchaseRequisitionService->updatePurchaseRequisition($purchaseRequisition, $request->validated());
        return redirect()->route('purchase-requisitions.index')->with('success', 'Purchase Requisition updated successfully');
    }

    public function destroy(PurchaseRequisition $purchaseRequisition)
    {
        $this->purchaseRequisitionService->deletePurchaseRequisition($purchaseRequisition);
        return redirect()->route('purchase-requisitions.index')->with('success', 'Purchase Requisition deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $purchase_requisition_code = $this->purchaseRequisitionService->createPurchaseRequisitionCode($companyId);
        return response()->json(['purchase_requisition_code' => $purchase_requisition_code]);
    }
}
