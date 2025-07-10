<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceiving;
use App\Models\GoodsReceivingItem;
use App\Models\InvoiceItem;
use App\Models\LeftOverNoteItem;
use App\Models\RawMaterialItem;
use App\Http\Requests\RawMaterialItemRequest;
use App\Models\RejectionReturnNoteItem;
use App\Models\Stock;
use App\Models\StoreIssueRequisitionItem;
use App\Services\ChartOfAccountService;
use App\Services\RawMaterialItemService;
use App\Services\CompanyService;
use App\Services\PartyService;
use App\Services\CategoryService;
use App\Services\SubCategoryService;
use App\Services\SubChartOfAccountService;
use Carbon\Carbon;

class RawMaterialItemController extends Controller
{
    protected $companyService;
    protected $rawMaterialItemService;
    protected $partyService;
    protected $categoryService;
    protected $subCategoryService;
    protected $subChartOfAccountService;
    protected $chartOfAccountService;

    public function __construct(RawMaterialItemService $rawMaterialItemService, CompanyService $companyService, PartyService $partyService, CategoryService $categoryService, SubCategoryService $subCategoryService, SubChartOfAccountService $subChartOfAccountService, ChartOfAccountService $chartOfAccountService)
    {
        $this->companyService = $companyService;
        $this->categoryService = $categoryService;
        $this->subCategoryService = $subCategoryService;
        $this->partyService = $partyService;
        $this->rawMaterialItemService = $rawMaterialItemService;
        $this->chartOfAccountService = $chartOfAccountService;
        $this->subChartOfAccountService = $subChartOfAccountService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Raw Material Item List')) {
            abort(403, 'Unauthorized action.');
        }
        $rawMaterialItems = $this->rawMaterialItemService->getAllRawMaterialItems();
        return view('admin.raw-material-items.index', compact('rawMaterialItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('Raw Material Item Create')) {
            abort(403, 'Unauthorized action.');
        }
        $newRawMaterialItemCode = null;
        if (!auth()->user()->hasRole('Superadmin')) {
            $newRawMaterialItemCode = $this->rawMaterialItemService->createRawMaterialItemCode(auth()->user()->employee->company_id);
        }
        $categories = $this->categoryService->getAllCategories();
        $subCategories = $this->subCategoryService->getAll();
        $companies = $this->companyService->getAllcompanies();
        $parties = $this->partyService->getAllParties();
        $chartOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        $subChartOfAccounts = $this->subChartOfAccountService->getAll();
        return view('admin.raw-material-items.create', compact('companies', 'parties', 'newRawMaterialItemCode', 'categories', 'subCategories', 'chartOfAccounts', 'subChartOfAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RawMaterialItemRequest $request)
    {
        if (!auth()->user()->hasPermission('Raw Material Item Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->rawMaterialItemService->createRawMaterialItem($request->validated());
        return redirect()->route('raw-material-items.index')->with('success', 'Raw Material Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermission('Raw Material Item View')) {
            abort(403, 'Unauthorized action.');
        }
        $rawMaterialItem = $this->rawMaterialItemService->getRawMaterialItemById($id);
        return view('admin.raw-material-items.show', compact('rawMaterialItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Raw Material Item Update')) {
            abort(403, 'Unauthorized action.');
        }
        $rawMaterialItem = $this->rawMaterialItemService->getRawMaterialItemById($id);
        $categories = $this->categoryService->getAllCategories();
        $subCategories = $this->subCategoryService->getAll();
        $companies = $this->companyService->getAllcompanies();
        $parties = $this->partyService->getAllParties();
        $chartOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        $subChartOfAccounts = $this->subChartOfAccountService->getAll();
        return view('admin.raw-material-items.edit', compact('rawMaterialItem', 'companies', 'parties', 'categories', 'subCategories', 'chartOfAccounts', 'subChartOfAccounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RawMaterialItemRequest $request, RawMaterialItem $rawMaterialItem)
    {
        if (!auth()->user()->hasPermission('Raw Material Item Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->rawMaterialItemService->updateRawMaterialItem($rawMaterialItem, $request->validated());
        return redirect()->route('raw-material-items.index')->with('success', 'Raw Material Item updated successfully');
    }

    public function destroy(RawMaterialItem $rawMaterialItem)
    {
        if (!auth()->user()->hasPermission('Raw Material Item Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->rawMaterialItemService->deleteRawMaterialItem($rawMaterialItem);
        return redirect()->route('raw-material-items.index')->with('success', 'Raw Material Item deleted successfully');
    }

    public function getRawMaterialItemsByCompany($companyId)
    {
        $rawMaterialItems = RawMaterialItem::where('company_id', $companyId)->orderBy('name', 'asc')->get();
        return response()->json(['rawMaterialItems' => $rawMaterialItems]);
    }

    public function createCodeByCompany($companyId)
    {
        $raw_material_item_code = $this->rawMaterialItemService->createRawMaterialItemCode($companyId);
        return response()->json(['raw_material_item_code' => $raw_material_item_code]);
    }

    public function getDetails($rawMaterialId)
    {
        $rawMaterialItem = $this->rawMaterialItemService->getRawMaterialItemById($rawMaterialId);

        $rawMaterialItem->balance = Stock::currentBalanceForItem(null, $rawMaterialItem->id ?? null)['balance'] ?? 0;

        $today = Carbon::today();
        $startDate = $today->copy()->subMonths(6);
        $endDate = $today->copy();

        $sirQty = StoreIssueRequisitionItem::where('raw_material_item_id', $rawMaterialId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('quantity') ?? 0;

        $lonQty = LeftOverNoteItem::where('raw_material_item_id', $rawMaterialId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('quantity') ?? 0;

        $rrnQty = RejectionReturnNoteItem::where('raw_material_item_id', $rawMaterialId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('quantity') ?? 0;

        $rawMaterialItem->consumption_6_months = $sirQty - $lonQty - $rrnQty;

        $grnLinkedInvoiceIds = GoodsReceiving::whereHas('items', function ($q) use ($rawMaterialId) {
                $q->where('raw_material_item_id', $rawMaterialId);
            })
            ->pluck('invoice_id')
            ->filter()
            ->unique()
            ->toArray();

        $lastPOItem = GoodsReceivingItem::with('goodsReceiving.invoice')
            ->where('raw_material_item_id', $rawMaterialId)
            ->whereHas('goodsReceiving', function ($query) {
                $query->where('is_approved', 1);
            })
            ->latest('created_at')
            ->first();

        $rawMaterialItem->last_po_ref = $lastPOItem?->goodsReceiving?->invoice?->code ?? null;
        $rawMaterialItem->last_po_price = $lastPOItem?->unit_price ?? null;

        $pendingPOItems = InvoiceItem::with('invoice')
            ->where('raw_material_item_id', $rawMaterialId)
            // ->whereNotIn('invoice_id', $grnLinkedInvoiceIds)
            ->whereHas('invoice', function ($query) {
                $query->where('is_approved', 1)->where('status', '!=', 'completed');
            })
            ->latest('created_at')
            ->get();

        $pendingPOItemsWithRemainingQty = $pendingPOItems->map(function ($item) use ($rawMaterialId) {
            $grns = GoodsReceiving::where('invoice_id', $item->invoice_id)->get();

            $receivedQty = 0;
            foreach ($grns as $grn) {
                $receivedQty += $grn->items()
                    ->where('raw_material_item_id', $rawMaterialId)
                    ->sum('balance_receivable');
            }

            $item->remaining_quantity = max(0, $item->quantity - $receivedQty);
            return $item;
        });

        $rawMaterialItem->pending_po_list = $pendingPOItemsWithRemainingQty
            ->pluck('invoice.code')
            ->filter()
            ->implode('-');

        $rawMaterialItem->pending_po_total_qty = $pendingPOItemsWithRemainingQty
            ->pluck('remaining_quantity')
            ->filter()
            ->implode(', ');

        return response()->json(['rawMaterialItem' => $rawMaterialItem]);
    }
}