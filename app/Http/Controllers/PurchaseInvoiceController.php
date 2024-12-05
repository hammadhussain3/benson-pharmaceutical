<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Batch;
use App\Models\GoodsReceiving;
use App\Http\Requests\InvoiceRequest;
use App\Services\CompanyService;
use App\Services\InvoiceService;
use App\Services\PartyService;
use App\Services\RawMaterialItemService;
use Illuminate\Http\Request;

class PurchaseInvoiceController extends Controller
{
    protected $invoiceService;
    protected $companyService;
    protected $partyService;
    protected $rawMaterialItemService;

    public function __construct(InvoiceService $invoiceService, CompanyService $companyService, PartyService $partyService, RawMaterialItemService $rawMaterialItemService)
    {
        $this->invoiceService = $invoiceService;
        $this->companyService = $companyService;
        $this->partyService = $partyService;
        $this->rawMaterialItemService = $rawMaterialItemService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Invoice List')) {
            abort(403, 'Unauthorized action.');
        }
        $invoices = $this->invoiceService->getAllInvoices('purchase');
        return view('admin.purchase-invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('Invoice Create')) {
            abort(403, 'Unauthorized action.');
        }
        if (auth()->user()->hasRole('Superadmin')) {
            $newInvoiceCode = 'PR';
        } else {
            $newSupplierCode = $this->invoiceService->createInvoiceCode(auth()->user()->employee->company_id, 'purchase');
        }
        $parties = $this->partyService->getAllParties();
        $companies = $this->companyService->getAllCompanies();
        $rawMaterialItems = $this->rawMaterialItemService->getAllRawMaterialItems();
        return view('admin.purchase-invoice.create', compact('parties','companies','rawMaterialItems', 'newInvoiceCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        if (!auth()->user()->hasPermission('Invoice Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->invoiceService->createInvoice($request->validated());
        return redirect()->route('purchase-invoices.index')->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermission('Invoice View')) {
            abort(403, 'Unauthorized action.');
        }
        $invoice = $this->invoiceService->getInvoiceById($id);
        return view('admin.purchase-invoice.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Invoice Update')) {
            abort(403, 'Unauthorized action.');
        }
        $invoice = $this->invoiceService->getInvoiceById($id);
        $parties = $this->partyService->getAllParties();
        $rawMaterialItems = $this->rawMaterialItemService->getAllRawMaterialItems();
        return view('admin.purchase-invoice.edit', compact('invoice', 'parties', 'rawMaterialItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, $id)
    {
        if (!auth()->user()->hasPermission('Invoice Update')) {
            abort(403, 'Unauthorized action.');
        }
        $invoice = $this->invoiceService->getInvoiceById($id);
        $this->invoiceService->updateInvoice($invoice, $request->validated());
        return redirect()->route('purchase-invoices.index')->with('success', 'Invoice updated successfully');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasPermission('Invoice Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $invoice = $this->invoiceService->getInvoiceById($id);
        $this->invoiceService->deleteInvoice($invoice);
        return redirect()->route('purchase-invoices.index')->with('success', 'Invoice deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $invoice_code = $this->invoiceService->createInvoiceCode($companyId, 'purchase');
        return response()->json(['invoice_code' => $invoice_code]);
    }

    public function getInvoicesByCompany($companyId)
    {
        $invoices = Invoice::where('company_id', $companyId)->where('status', 'pending')->where('type', 'purchase')->orderBy('code', 'asc')->get();
        return response()->json(['invoices' => $invoices]);
    }

    public function getInvoiceDetailsById($invoiceId)
    {
        $invoice = Invoice::with('items.productVariation', 'items.rawMaterialItem', 'party')->where('id', $invoiceId)->first();
        $goods_receivings = GoodsReceiving::with('items')->where('invoice_id', $invoice->id)->get();

        $invoice->items->map(function ($item) use ($goods_receivings) {
            // Determine if the item is a product or raw material
            if ($item->product_id) {
                // For product
                $receivedQuantity = $goods_receivings->flatMap->items
                    ->where('product_id', $item->product_id) // Match product_id
                    ->sum('balance_receivable'); // Sum received quantities

                // Add received quantity as custom attribute
                $item->received_quantity = $receivedQuantity;
                $item->batches = Batch::where('product_id', $item->product_id)->orderBy('batch_no', 'asc')->get()->toArray() ?? null;
            } elseif ($item->raw_material_item_id) {
                // For raw material
                $receivedQuantity = $goods_receivings->flatMap->items
                    ->where('raw_material_item_id', $item->raw_material_item_id) // Match raw_material_item_id
                    ->sum('balance_receivable'); // Sum received quantities

                // Add received quantity as custom attribute
                $item->received_quantity = $receivedQuantity;
                $item->batches = null;
            }

            return $item;
        });
        return response()->json(['invoice' => $invoice]);
    }
}
