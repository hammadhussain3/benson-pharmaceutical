<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Batch;
use App\Models\GoodsReceiving;
use App\Http\Requests\InvoiceRequest;
use App\Services\CompanyService;
use App\Services\InvoiceService;
use App\Services\PartyService;
use App\Services\ProductService;
use App\Services\RawMaterialItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class InvoiceController extends Controller
{
    protected $invoiceService;
    protected $companyService;
    protected $partyService;
    protected $productService;
    protected $rawMaterialItemService;

    public function __construct(InvoiceService $invoiceService, CompanyService $companyService, PartyService $partyService, ProductService $productService, RawMaterialItemService $rawMaterialItemService)
    {
        $this->invoiceService = $invoiceService;
        $this->companyService = $companyService;
        $this->partyService = $partyService;
        $this->productService = $productService;
        $this->rawMaterialItemService = $rawMaterialItemService;
    }

    public function index()
    {
        $routeConfig = [
            'sale-invoices.index' => [
                'view' => 'admin.sale-invoice.index',
                'type' => 'sale',
            ],
            'purchase-invoices.index' => [
                'view' => 'admin.purchase-invoice.index',
                'type' => 'purchase',
            ],
            'quotations.index' => [
                'view' => 'admin.quotations.index',
                'type' => 'quotation',
            ],
        ];

        $routeName = Route::currentRouteName();

        $invoices = $this->invoiceService->getAllInvoices($routeConfig[$routeName]['type']);

        return view($routeConfig[$routeName]['view'], compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $routeConfig = [
            'sale-invoices.create' => [
                'view' => 'admin.sale-invoice.create',
                'products' => $this->productService->getAllProducts(),
                'newInvoiceCode' => 'SI',
            ],
            'purchase-invoices.create' => [
                'view' => 'admin.purchase-invoice.create',
                'products' => $this->rawMaterialItemService->getAllRawMaterialItems(),
                'newInvoiceCode' => 'PR',
            ],
            'quotations.create' => [
                'view' => 'admin.quotations.create',
                'products' => $this->productService->getAllProducts(),
                'newInvoiceCode' => 'QT',
            ],
        ];

        $routeName = Route::currentRouteName();
        $newInvoiceCode = $routeConfig[$routeName]['newInvoiceCode'];
        $parties = $this->partyService->getAllParties();
        $companies = $this->companyService->getAllCompanies();
        $products = $routeConfig[$routeName]['products'];
        return view($routeConfig[$routeName]['view'], compact('parties','companies','products', 'newInvoiceCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        $this->invoiceService->createInvoice($request->validated());
        return redirect()->route('purchase-invoices.index')->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = $this->invoiceService->getInvoiceById($id);
        return view('admin.purchase-invoice.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = $this->invoiceService->getInvoiceById($id);
        $parties = $this->partyService->getAllParties();
        $companies = $this->companyService->getAllCompanies();
        $products = $this->productService->getAllProducts();
        $rawMaterialItems = $this->rawMaterialItemService->getAllRawMaterialItems();
        return view('admin.purchase-invoice.edit', compact('invoice','parties','companies','products', 'rawMaterialItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $this->invoiceService->updateInvoice($invoice, $request->validated());
        return redirect()->route('purchase-invoices.index')->with('success', 'Invoice updated successfully');
    }

    public function destroy(Invoice $invoice)
    {
        $this->invoiceService->deleteInvoice($invoice);
        return redirect()->route('purchase-invoices.index')->with('success', 'Invoice deleted successfully');
    }

    public function createCodeByCompany(Request $request, $companyId)
    {
        $invoice_code = $this->invoiceService->createInvoiceCode($companyId, $request->input('document_type'));
        return response()->json(['invoice_code' => $invoice_code]);
    }

    public function getInvoicesByCompany($companyId)
    {
        $invoices = Invoice::where('company_id', $companyId)->where('status', 'pending')->where('type', 'purchase')->orderBy('code', 'asc')->get();
        return response()->json(['invoices' => $invoices]);
    }

    public function getInvoiceDetailsById($invoiceId)
    {
        $invoice = Invoice::with('items.product', 'items.rawMaterialItem', 'party')->where('id', $invoiceId)->first();
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
