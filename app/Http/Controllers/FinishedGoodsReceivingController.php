<?php

namespace App\Http\Controllers;

use App\Models\FinishedGoodsReceiving;
use App\Http\Requests\FinishedGoodsReceivingRequest;
use App\Services\FinishedGoodsReceivingService;
use App\Services\ProductVariationService;
use App\Services\CompanyService;
use App\Services\ProductService;
use App\Services\BatchService;

class FinishedGoodsReceivingController extends Controller
{
    protected $finishedGoodsReceivingService;
    protected $productVariationService;
    protected $companyService;
    protected $productService;
    protected $batchService;

    public function __construct(FinishedGoodsReceivingService $finishedGoodsReceivingService, CompanyService $companyService, ProductService $productService, BatchService $batchService, ProductVariationService $productVariationService)
    {
        $this->finishedGoodsReceivingService = $finishedGoodsReceivingService;
        $this->productVariationService = $productVariationService;
        $this->companyService = $companyService;
        $this->productService = $productService;
        $this->batchService = $batchService;
    }

    public function index()
    {
        $finishedGoodsReceivings = $this->finishedGoodsReceivingService->getAllFinishedGoodsReceivings();
        return view('admin.finished-goods-receivings.index', compact('finishedGoodsReceivings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $newFinishedGoodsCode = "FGR";
        } else {
            $newFinishedGoodsCode = $this->finishedGoodsReceivingService->createFinishedGoodsReceivingCode(auth()->user()->employee->company_id);
        }
        $companies = $this->companyService->getAllCompanies();
        $products = $this->productService->getAllProducts();
        $batches = $this->batchService->getAllBatches();
        $productVariations = $this->productVariationService->getAllProductVariations();
        return view('admin.finished-goods-receivings.create', compact('companies', 'products', 'batches', 'productVariations', 'newFinishedGoodsCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FinishedGoodsReceivingRequest $request)
    {
        $this->finishedGoodsReceivingService->createFinishedGoodsReceiving($request->validated());
        return redirect()->route('finished-goods-receivings.index')->with('success', 'Finished Goods Receiving Note created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $finishedGoodsReceiving = $this->finishedGoodsReceivingService->getFinishedGoodsReceivingById($id);
        return view('admin.finished-goods-receivings.show', compact('finishedGoodsReceiving'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $finishedGoodsReceiving = $this->finishedGoodsReceivingService->getFinishedGoodsReceivingById($id);
        $companies = $this->companyService->getAllCompanies();
        $products = $this->productService->getAllProducts();
        $batches = $this->batchService->getAllBatches();
        $productVariations = $this->productVariationService->getAllProductVariations();
        return view('admin.finished-goods-receivings.edit', compact('finishedGoodsReceiving','companies','products', 'batches', 'productVariations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FinishedGoodsReceivingRequest $request, FinishedGoodsReceiving $finishedGoodsReceiving)
    {
        $this->finishedGoodsReceivingService->updateFinishedGoodsReceiving($finishedGoodsReceiving, $request->validated());
        return redirect()->route('finished-goods-receivings.index')->with('success', 'Finished Goods Receiving Note updated successfully');
    }

    public function destroy(FinishedGoodsReceiving $finishedGoodsReceiving)
    {
        $this->finishedGoodsReceivingService->deleteFinishedGoodsReceiving($finishedGoodsReceiving);
        return redirect()->route('finished-goods-receivings.index')->with('success', 'Finished Goods Receiving Note deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $finished_goods_code = $this->finishedGoodsReceivingService->createFinishedGoodsReceivingCode($companyId);
        return response()->json(['finished_goods_code' => $finished_goods_code]);
    }
}
