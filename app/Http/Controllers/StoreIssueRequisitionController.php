<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceiving;
use App\Models\StoreIssueRequisition;
use App\Http\Requests\StoreIssueRequisitionRequest;
use App\Services\ProductVariationService;
use App\Services\StoreIssueRequisitionService;
use App\Services\ChartOfAccountService;
use App\Services\RawMaterialItemService;
use App\Services\CompanyService;
use App\Services\ProductService;
use App\Services\BatchService;
use Illuminate\Http\Request;

class StoreIssueRequisitionController extends Controller
{
    protected $storeIssueRequisitionService;
    protected $productVariationService;
    protected $chartOfAccountService;
    protected $rawMaterialItemService;
    protected $batchService;
    protected $companyService;
    protected $productService;

    public function __construct(BatchService $batchService, StoreIssueRequisitionService $storeIssueRequisitionService, RawMaterialItemService $rawMaterialItemService, ChartOfAccountService $chartOfAccountService, CompanyService $companyService, ProductService $productService, ProductVariationService $productVariationService)
    {
        $this->storeIssueRequisitionService = $storeIssueRequisitionService;
        $this->productVariationService = $productVariationService;
        $this->chartOfAccountService = $chartOfAccountService;
        $this->rawMaterialItemService = $rawMaterialItemService;
        $this->companyService = $companyService;
        $this->productService = $productService;
        $this->batchService = $batchService;
    }

    public function index()
    {        
        $requisitions = $this->storeIssueRequisitionService->getAll();
        return view('admin.store-issue-requisition.index', compact('requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $newRequisitionCode = "SIR";
        } else {
            $newRequisitionCode = $this->storeIssueRequisitionService->createCode(auth()->user()->employee->company_id);
        }
        $companies = $this->companyService->getAllCompanies();
        $chartOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        $products = $this->productService->getAllProducts();
        $rawMaterialItems = $this->rawMaterialItemService->getAllRawMaterialItems();
        $productVariations = $this->productVariationService->getAllProductVariations();
        return view('admin.store-issue-requisition.create', compact('companies', 'products', 'rawMaterialItems', 'chartOfAccounts', 'productVariations', 'newRequisitionCode'));
    }

    public function productionCreate()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $newRequisitionCode = "SIR";
        } else {
            $newRequisitionCode = $this->storeIssueRequisitionService->createCode(auth()->user()->employee->company_id);
        }
        $companies = $this->companyService->getAllCompanies();
        $products = $this->productService->getAllProducts();
        $rawMaterialItems = $this->rawMaterialItemService->getAllRawMaterialItems();
        $batches = $this->batchService->getAllBatches();
        return view('admin.store-issue-requisition.production-create', compact('companies','products','rawMaterialItems', 'batches', 'newRequisitionCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIssueRequisitionRequest $request)
    {
        $this->storeIssueRequisitionService->create($request->validated());
        return redirect()->route('store-issue-requisitions.index')->with('success', 'Store Issue Requisition created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $requisition = $this->storeIssueRequisitionService->getById($id);
        return view('admin.store-issue-requisition.show', compact('requisition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $requisition = $this->storeIssueRequisitionService->getById($id);
        $companies = $this->companyService->getAllCompanies();
        $products = $this->productService->getAllProducts();
        $chartOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        $rawMaterialItems = $this->rawMaterialItemService->getAllRawMaterialItems();
        $batches = $this->batchService->getAllBatches();
        $productVariations = $this->productVariationService->getAllProductVariations();
        return view('admin.store-issue-requisition.edit', compact('requisition', 'companies', 'products', 'chartOfAccounts', 'rawMaterialItems', 'productVariations', 'batches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreIssueRequisitionRequest $request, StoreIssueRequisition $storeIssueRequisition)
    {
        $this->storeIssueRequisitionService->update($storeIssueRequisition, $request->validated());
        return redirect()->route('store-issue-requisitions.index')->with('success', 'Store Issue Requisition updated successfully');
    }

    public function destroy(StoreIssueRequisition $storeIssueRequisition)
    {
        $this->storeIssueRequisitionService->delete($storeIssueRequisition);
        return redirect()->route('store-issue-requisitions.index')->with('success', 'Store Issue Requisition deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $store_requisition_code = $this->storeIssueRequisitionService->createCode($companyId);
        return response()->json(['store_requisition_code' => $store_requisition_code]);
    }

    public function getGeneralStoreRequisitionsByCompany($companyId)
    {
        $storeIssueRequisitions = StoreIssueRequisition::where('company_id', $companyId)->where('is_general', '1')->orderBy('code', 'asc')->get();
        return response()->json(['storeIssueRequisitions' => $storeIssueRequisitions]);
    }

    public function getProductionStoreRequisitionsByCompany($companyId, Request $request)
    {
        $storeIssueRequisitions = StoreIssueRequisition::where('company_id', $companyId)->where('product_id', $request->productId)->where('is_production', '1')->orderBy('code', 'asc')->get();
        return response()->json(['storeIssueRequisitions' => $storeIssueRequisitions]);
    }

    public function getGeneralStoreRequisitionDetailsById($requisitionId, Request $request)
    {
        // Fetch requisition with related items
        $requisition = StoreIssueRequisition::with('items.product', 'items.raw_material_item')
            ->where('id', $requisitionId)
            ->first();

        // Fetch goods receiving with related items
        $goodsReceivings = GoodsReceiving::with('items.product', 'items.rawMaterialItem')
            ->where('supplier_bill_no', $request->supplierBillNo)
            ->where('invoice_id', $request->invoiceId)
            ->first();

        // Check if both exist
        if ($requisition && $goodsReceivings) {
            // Extract items from both
            $requisitionItems = collect($requisition->items); // Convert to collection for easy handling
            $goodsReceivingItems = collect($goodsReceivings->items);

            // Find common items based on product_id or raw_material_item_id
            $commonItems = $requisitionItems->filter(function ($reqItem) use ($goodsReceivingItems) {
                return $goodsReceivingItems->contains(function ($grItem) use ($reqItem) {
                    return ($reqItem->product_id == $grItem->product_id && $reqItem->product_id !== null)
                        || ($reqItem->raw_material_item_id == $grItem->raw_material_item_id && $reqItem->raw_material_item_id !== null);
                });
            });

            // Transform to include only required fields
            $result = $commonItems->map(function ($item) {
                return [
                    'raw_material_item_id' => $item->raw_material_item_id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'unit' => $item->unit,
                    'total' => $item->total,
                    'product' => $item->product ? [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                    ] : null,
                    'raw_material_item' => $item->raw_material_item ? [
                        'id' => $item->raw_material_item->id,
                        'name' => $item->raw_material_item->name,
                    ] : null,
                ];
            });

            // Return only the filtered fields
            return response()->json(['items' => $result->values()]);
        } else {
            return response()->json(['error' => 'Requisition or Goods Receiving not found.'], 404);
        }
    }

    public function getProductionStoreRequisitionDetailsById($requisitionId, Request $request)
    {
        // Fetch requisition with related items
        $requisition = StoreIssueRequisition::with('items.raw_material_item')
            ->where('id', $requisitionId)
            ->first();

        if($request->batchId && $requisition->batch_id == $request->batchId){
            // Return only the filtered fields
            return response()->json(['items' => $requisition->items]);
        } else {
            return response()->json(['error' => 'Requisition not found.'], 404);
        }
    }
}
