<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Requests\InvoiceRequest;
use App\Services\ProductVariationService;
use App\Services\CompanyService;
use App\Services\InvoiceService;
use App\Services\PartyService;
use App\Services\BatchService;

class SaleInvoiceController extends Controller
{
    protected $productVariationService;
    protected $invoiceService;
    protected $companyService;
    protected $partyService;
    protected $batchService;

    public function __construct(InvoiceService $invoiceService, CompanyService $companyService, PartyService $partyService, ProductVariationService $productVariationService, BatchService $batchService)
    {
        $this->productVariationService = $productVariationService;
        $this->invoiceService = $invoiceService;
        $this->companyService = $companyService;
        $this->partyService = $partyService;
        $this->batchService = $batchService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Invoice List')) {
            abort(403, 'Unauthorized action.');
        }
        $invoices = $this->invoiceService->getAllInvoices('sale');
        return view('admin.sale-invoice.index', compact('invoices'));
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
            $newInvoiceCode = 'SI';
        } else {
            $newSupplierCode = $this->invoiceService->createInvoiceCode(auth()->user()->employee->company_id, 'sale');
        }
        $parties = $this->partyService->getAllParties();
        $companies = $this->companyService->getAllCompanies();
        $batches = $this->batchService->getAllBatches();
        $productVariations = $this->productVariationService->getAllProductVariations();
        return view('admin.sale-invoice.create', compact('parties','companies', 'productVariations', 'batches', 'newInvoiceCode'));
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
        return redirect()->route('sale-invoices.index')->with('success', 'Invoice created successfully.');
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
        return view('admin.sale-invoice.show', compact('invoice'));
    }

    public function saleWarranties()
    {
        if (!auth()->user()->hasPermission('Invoice View')) {
            abort(403, 'Unauthorized action.');
        }
        $invoices = $this->invoiceService->getAllInvoices('sale');
        return view('admin.sale-invoice.warranty-list', compact('invoices'));
    }

    public function warranty($id)
    {
        if (!auth()->user()->hasPermission('Invoice View')) {
            abort(403, 'Unauthorized action.');
        }
        $invoice = $this->invoiceService->getInvoiceById($id);
        return view('admin.sale-invoice.warranty', compact('invoice'));
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
        $companies = $this->companyService->getAllCompanies();
        $parties = $this->partyService->getAllParties();
        $batches = $this->batchService->getAllBatches();
        $productVariations = $this->productVariationService->getAllProductVariations();
        return view('admin.sale-invoice.edit', compact('invoice', 'parties', 'companies', 'productVariations', 'batches'));
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
        return redirect()->route('sale-invoices.index')->with('success', 'Invoice updated successfully');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasPermission('Invoice Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $invoice = $this->invoiceService->getInvoiceById($id);
        $this->invoiceService->deleteInvoice($invoice);
        return redirect()->route('sale-invoices.index')->with('success', 'Invoice deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $invoice_code = $this->invoiceService->createInvoiceCode($companyId, 'sale');
        return response()->json(['invoice_code' => $invoice_code]);
    }
}