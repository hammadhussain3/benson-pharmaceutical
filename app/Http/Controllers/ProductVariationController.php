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
        if (!auth()->user()->hasPermission('Product Variation List')) {
            abort(403, 'Unauthorized action.');
        }
        $productVariations = $this->productVariationService->getAllProductVariations();
        return view('admin.product-variations.index', compact('productVariations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('Product Variation Create')) {
            abort(403, 'Unauthorized action.');
        }
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
        if (!auth()->user()->hasPermission('Product Variation Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->productVariationService->createProductVariation($request->validated());
        return redirect()->route('product-variations.index')->with('success', 'Product Variation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermission('Product Variation View')) {
            abort(403, 'Unauthorized action.');
        }
        $productVariation = $this->productVariationService->getProductVariationById($id);
        return view('admin.product-variations.show', compact('productVariation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Product Variation Update')) {
            abort(403, 'Unauthorized action.');
        }
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
        if (!auth()->user()->hasPermission('Product Variation Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->productVariationService->updateProductVariation($productVariation, $request->validated());
        return redirect()->route('product-variations.index')->with('success', 'Product Variation updated successfully');
    }

    public function destroy(ProductVariation $productVariation)
    {
        if (!auth()->user()->hasPermission('Product Variation Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->productVariationService->deleteProductVariation($productVariation);
        return redirect()->route('product-variations.index')->with('success', 'Product Variation deleted successfully');
    }

    public function getProductVariationsByProduct($productId)
    {
        $productVariations = ProductVariation::with(['product', 'packingType', 'packSize'])->where('product_id', $productId)->get();
        return response()->json(['productVariations' => $productVariations]);
    }

    public function getProductVariationsByComapny($companyId)
    {
        $productVariations = ProductVariation::with(['product', 'packingType', 'packSize'])->where('company_id', $companyId)->get();
        return response()->json(['productVariations' => $productVariations]);
    }
}
