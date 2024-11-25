<?php

namespace App\Http\Controllers;

use App\Models\DosageForm;
use App\Models\PackForm;
use App\Models\PackingType;
use App\Models\PackSize;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Http\Requests\ProductVariationRequest;
use App\Services\ProductVariationService;
use App\Services\CompanyService;

class ProductVariationController extends Controller
{
    protected $companyService;
    protected $productVariationService;

    public function __construct(ProductVariationService $productVariationService, CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->productVariationService = $productVariationService;
    }

    public function index()
    {
        $productVariations = $this->productVariationService->getAllProductVariations();
        return view('admin.product-variations.index', compact('productVariations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = $this->companyService->getAllCompanies();
        $products = Product::orderBy('name', 'asc')->get();
        $dosage_forms = DosageForm::orderBy('name', 'asc')->get();
        $pack_forms = PackForm::orderBy('name', 'asc')->get();
        $pack_sizes = PackSize::orderBy('name', 'asc')->get();
        $packing_types = PackingType::orderBy('name', 'asc')->get();
        return view('admin.product-variations.create', compact('companies', 'products', 'dosage_forms', 'pack_forms', 'pack_sizes', 'packing_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductVariationRequest $request)
    {
        $this->productVariationService->createProductVariation($request->validated());
        return redirect()->route('product-variations.index')->with('success', 'Product Variation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $productVariation = $this->productVariationService->getProductVariationById($id);
        return view('admin.product-variations.show', compact('productVariation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $productVariation = $this->productVariationService->getProductVariationById($id);
        $companies = $this->companyService->getAllCompanies();
        $products = Product::orderBy('name', 'asc')->get();
        $dosage_forms = DosageForm::orderBy('name', 'asc')->get();
        $pack_forms = PackForm::orderBy('name', 'asc')->get();
        $pack_sizes = PackSize::orderBy('name', 'asc')->get();
        $packing_types = PackingType::orderBy('name', 'asc')->get();
        return view('admin.product-variations.edit', compact('productVariation', 'companies', 'products', 'dosage_forms', 'pack_forms', 'pack_sizes', 'packing_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductVariationRequest $request, ProductVariation $productVariation)
    {
        $this->productVariationService->updateProductVariation($productVariation, $request->validated());
        return redirect()->route('product-variations.index')->with('success', 'Product Variation updated successfully');
    }

    public function destroy(ProductVariation $productVariation)
    {
        $this->productVariationService->deleteProductVariation($productVariation);
        return redirect()->route('product-variations.index')->with('success', 'Product Variation deleted successfully');
    }

    public function getProductVariationsByCompany($productId)
    {
        $productVariations = ProductVariation::with(['product', 'packingType', 'packSize'])->where('product_id', $productId)->get();
        return response()->json(['productVariations' => $productVariations]);
    }
}
