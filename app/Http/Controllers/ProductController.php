<?php

namespace App\Http\Controllers;

use App\Models\ProductGroup;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use App\Services\CompanyService;

class ProductController extends Controller
{
    protected $companyService;
    protected $productService;

    public function __construct(ProductService $productService, CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = $this->companyService->getAllCompanies();
        $productGroups = ProductGroup::orderBy('name', 'asc')->get();
        return view('admin.products.create', compact('companies', 'productGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $this->productService->createProduct($request->validated());
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = $this->productService->getProductById($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $companies = $this->companyService->getAllCompanies();
        $product = $this->productService->getProductById($id);
        $productGroups = ProductGroup::orderBy('name', 'asc')->get();
        return view('admin.products.edit', compact('product', 'companies', 'productGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->productService->updateProduct($product, $request->validated());
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function getProductsByCompany($companyId)
    {
        $products = Product::where('company_id', $companyId)->orderBy('name', 'asc')->get();
        return response()->json(['products' => $products]);
    }
}
