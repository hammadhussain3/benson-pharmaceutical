<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ProductVariation;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\BatchRequest;
use App\Services\CompanyService;
use App\Services\BatchService;
use App\Services\ProductService;

class BatchController extends Controller
{
    protected $batchService;
    protected $companyService;
    protected $productService;

    public function __construct(BatchService $batchService, CompanyService $companyService, ProductService $productService)
    {
        $this->batchService = $batchService;
        $this->companyService = $companyService;
        $this->productService = $productService;
    }

    public function index()
    {
        $batches = $this->batchService->getAllBatches();
        return view('admin.batch.index', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = $this->companyService->getAllCompanies();
        $products = $this->productService->getAllProducts();
        return view('admin.batch.create', compact('companies','products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BatchRequest $request)
    {
        $this->batchService->createBatch($request->validated());
        return redirect()->route('batches.index')->with('success', 'Batch created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $batch = $this->batchService->getBatchById($id);
        return view('admin.batch.show', compact('batch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $batch = $this->batchService->getBatchById($id);
        $companies = $this->companyService->getAllCompanies();
        $products = $this->productService->getAllProducts();
        return view('admin.batch.edit', compact('batch', 'companies', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BatchRequest $request, Batch $batch)
    {
        $this->batchService->updateBatch($batch, $request->validated());
        return redirect()->route('batches.index')->with('success', 'Batch updated successfully');
    }

    public function destroy(Batch $batch)
    {
        $this->batchService->deleteBatch($batch);
        return redirect()->route('batches.index')->with('success', 'Batch deleted successfully');
    }

    public function getBatchesByProductId($productId)
    {
        $batches = Batch::where('product_id', $productId)->get();
        return response()->json(['batches' => $batches]);
    }

    public function getBatchesByProductVariationId($productVariationId)
    {
        $productVariation = ProductVariation::findOrFail($productVariationId);
        $batches = Batch::where('product_id', $productVariation->product_id)->get();
        return response()->json(['batches' => $batches]);
    }
}
