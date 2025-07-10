<?php

namespace App\Http\Controllers;

use App\Models\LeftOverNoteItem;
use App\Models\RejectionReturnNoteItem;
use App\Models\StoreIssueRequisitionItem;
use App\Services\PurchaseInvoiceService;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Batch;
use App\Models\GoodsReceiving;
use App\Http\Requests\PurchaseInvoiceRequest;
use App\Models\InvoiceItem;
use App\Services\CompanyService;
use App\Services\InvoiceService;
use App\Services\PartyService;
use App\Services\RawMaterialItemService;
use Illuminate\Http\Request;

class PurchaseInvoiceController extends Controller
{
    protected $invoiceService;
    protected $purchaseInvoiceService;
    protected $companyService;
    protected $partyService;
    protected $rawMaterialItemService;

    public function __construct(PurchaseInvoiceService $purchaseInvoiceService, InvoiceService $invoiceService, CompanyService $companyService, PartyService $partyService, RawMaterialItemService $rawMaterialItemService)
    {
        $this->invoiceService = $invoiceService;
        $this->purchaseInvoiceService = $purchaseInvoiceService;
        $this->companyService = $companyService;
        $this->partyService = $partyService;
        $this->rawMaterialItemService = $rawMaterialItemService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Purchase Invoice List')) {
            abort(403, 'Unauthorized action.');
        }
        

        $invoices = $this->purchaseInvoiceService->getAll();
        return view('admin.purchase-invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('Purchase Invoice Create')) {
            abort(403, 'Unauthorized action.');
        }
        if (auth()->user()->hasRole('Superadmin')) {
            $newInvoiceCode = 'PO';
        } else {
            $newInvoiceCode = $this->purchaseInvoiceService->generateCode(auth()->user()->employee->company_id);
        }
        $parties = $this->partyService->getAllParties();
        $companies = $this->companyService->getAllCompanies();
        $rawMaterialItems = $this->rawMaterialItemService->getAllRawMaterialItems();
        return view('admin.purchase-invoice.create', compact('parties','companies','rawMaterialItems', 'newInvoiceCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PurchaseInvoiceRequest $request)
    {
        if (!auth()->user()->hasPermission('Purchase Invoice Create')) {
            abort(403, 'Unauthorized action.');
        }
        $invoice = $this->purchaseInvoiceService->create($request->validated());
        return redirect()->route('purchase-invoices.show', $invoice->id)->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermission('Purchase Invoice View')) {
            abort(403, 'Unauthorized action.');
        }
        $invoice = $this->purchaseInvoiceService->getById($id);
        return view('admin.purchase-invoice.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Purchase Invoice Update')) {
            abort(403, 'Unauthorized action.');
        }
        $invoice = $this->purchaseInvoiceService->getById($id);
        $parties = $this->partyService->getAllParties();
        $rawMaterialItems = $this->rawMaterialItemService->getAllRawMaterialItems();
        return view('admin.purchase-invoice.edit', compact('invoice', 'parties', 'rawMaterialItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PurchaseInvoiceRequest $request, $id)
    {
        if (!auth()->user()->hasPermission('Purchase Invoice Update')) {
            abort(403, 'Unauthorized action.');
        }
        $invoice = $this->purchaseInvoiceService->getById($id);
        $this->purchaseInvoiceService->update($invoice, $request->validated());
        return redirect()->route('purchase-invoices.show', $invoice->id)->with('success', 'Invoice updated successfully');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasPermission('Purchase Invoice Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $invoice = $this->purchaseInvoiceService->getById($id);
        $this->purchaseInvoiceService->delete($invoice);
        return redirect()->route('purchase-invoices.index')->with('success', 'Invoice deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $invoice_code = $this->purchaseInvoiceService->generateCode($companyId);
        return response()->json(['invoice_code' => $invoice_code]);
    }

    public function getInvoicesByCompany($companyId)
    {
        $invoices = Invoice::where('company_id', $companyId)->where('is_approved', 1)->where('status', '!=', 'completed')->where('type', 'purchase')->orderBy('code', 'asc')->get();
        return response()->json(['invoices' => $invoices]);
    }

    public function getInvoiceDetailsById($invoiceId)
    {
        $invoice = Invoice::with('items.productVariation', 'items.rawMaterialItem', 'party')->where('id', $invoiceId)->first();
        $goods_receivings = GoodsReceiving::with('items')->where('invoice_id', $invoice->id)->get();

        $filteredItems = $invoice->items->filter(function ($item) use ($goods_receivings) {
            // Default received quantity
            $receivedQuantity = 0;

            if ($item->product_id) {
                $receivedQuantity = $goods_receivings->flatMap->items
                    ->where('product_id', $item->product_id)
                    ->sum('balance_receivable');

                $item->batches = Batch::where('product_id', $item->product_id)
                    ->orderBy('batch_no', 'asc')->get()->toArray() ?? null;

            } elseif ($item->raw_material_item_id) {
                $receivedQuantity = $goods_receivings->flatMap->items
                    ->where('raw_material_item_id', $item->raw_material_item_id)
                    ->sum('balance_receivable');

                $item->batches = null;
            }

            $item->received_quantity = $receivedQuantity;

            // Keep item only if not fully received
            return $receivedQuantity < $item->quantity;
        });

        // Replace items relation with filtered collection
        $invoice->setRelation('items', $filteredItems->values());

        return response()->json(['invoice' => $invoice]);
    }

    public function getLastPurchase($rawMaterialId){
        $lastPurchase = InvoiceItem::getLastPurchaseByRawMaterial($rawMaterialId);
        return response()->json(['lastPurchase' => $lastPurchase]);
    }
}