<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceiving;
use Illuminate\Http\Request;
use App\Http\Requests\GoodsReceivingRequest;
use App\Services\GoodsReceivingService;
use App\Services\CompanyService;
use App\Services\InvoiceService;
use App\Services\BatchService;

class GoodsReceivingController extends Controller
{
    protected $goodsReceivingService;
    protected $invoiceService;
    protected $companyService;
    protected $batchService;

    public function __construct(GoodsReceivingService $goodsReceivingService, InvoiceService $invoiceService, CompanyService $companyService, BatchService $batchService)
    {
        $this->goodsReceivingService = $goodsReceivingService;
        $this->invoiceService = $invoiceService;
        $this->companyService = $companyService;
        $this->batchService = $batchService;
    }

    public function index()
    {
        $goodsReceivings = $this->goodsReceivingService->getAllGoodsReceivings();
        return view('admin.goods-receivings.index', compact('goodsReceivings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $invoices = $this->invoiceService->getAllInvoices();
        $companies = $this->companyService->getAllCompanies();
        $batches = $this->batchService->getAllBatches();
        return view('admin.goods-receivings.create', compact('invoices','batches','companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GoodsReceivingRequest $request)
    {
        $this->goodsReceivingService->createGoodsReceiving($request->validated());
        return redirect()->route('goods-receivings.index')->with('success', 'Goods Receiving Note created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $goodsReceiving = $this->goodsReceivingService->getGoodsReceivingById($id);
        return view('admin.goods-receivings.show', compact('goodsReceiving'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $goodsReceiving = $this->goodsReceivingService->getGoodsReceivingById($id);
        $invoices = $this->invoiceService->getAllInvoices();
        $companies = $this->companyService->getAllCompanies();
        $batches = $this->batchService->getAllBatches();
        return view('admin.goods-receivings.edit', compact('goodsReceiving','invoices','companies','batches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GoodsReceivingRequest $request, GoodsReceiving $goodsReceiving)
    {
        $this->goodsReceivingService->updateGoodsReceiving($goodsReceiving, $request->validated());
        return redirect()->route('goods-receivings.index')->with('success', 'Goods Receiving Note updated successfully');
    }

    public function destroy(GoodsReceiving $goodsReceiving)
    {
        $goodsReceiving = $this->goodsReceivingService->deleteGoodsReceiving($goodsReceiving);
        return redirect()->route('goods-receivings.index')->with('success', 'Goods Receiving deleted successfully');
    }

    public function getGoodReceivingsByInvoice($invoiceId)
    {
        $goodsReceivings = GoodsReceiving::where('invoice_id', $invoiceId)->orderBy('supplier_bill_no', 'asc')->get();
        return response()->json(['goodsReceivings' => $goodsReceivings]);
    }
}
