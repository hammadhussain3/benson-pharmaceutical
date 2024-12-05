<?php

namespace App\Http\Controllers;

use App\Models\ProductGroup;
use App\Http\Requests\ProductGroupRequest;
use App\Services\ProductGroupService;
use App\Services\CompanyService;

class ProductGroupController extends Controller
{
    protected $companyService;
    protected $productGroupService;

    public function __construct(ProductGroupService $productGroupService, CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->productGroupService = $productGroupService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('ProductGroup List')) {
            abort(403, 'Unauthorized action.');
        }
        $productGroups = $this->productGroupService->getAllProductGroups();
        return view('admin.product-group.index', compact('productGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('ProductGroup Create')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllCompanies();
        return view('admin.product-group.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductGroupRequest $request)
    {
        if (!auth()->user()->hasPermission('ProductGroup Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->productGroupService->createProductGroup($request->validated());
        return redirect()->route('product-groups.index')->with('success', 'Product Group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermission('ProductGroup View')) {
            abort(403, 'Unauthorized action.');
        }
        $productGroup = $this->productGroupService->getProductGroupById($id);
        return view('admin.product-group.show', compact('productGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermission('ProductGroup Update')) {
            abort(403, 'Unauthorized action.');
        }
        $productGroup = $this->productGroupService->getProductGroupById($id);
        $companies = $this->companyService->getAllCompanies();
        return view('admin.product-group.edit', compact('productGroup','companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductGroupRequest $request, ProductGroup $productGroup)
    {
        if (!auth()->user()->hasPermission('ProductGroup Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->productGroupService->updateProductGroup($productGroup, $request->validated());
        return redirect()->route('product-groups.index')->with('success', 'Product Group updated successfully');
    }

    public function destroy(ProductGroup $productGroup)
    {
        if (!auth()->user()->hasPermission('ProductGroup Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->productGroupService->deleteProductGroup($productGroup);
        return redirect()->route('product-groups.index')->with('success', 'Product Group deleted successfully');
    }

    public function getProductGroupsByCompany($companyId)
    {
        $productGroups = ProductGroup::where('company_id', $companyId)->get();
        return response()->json(['productGroups' => $productGroups]);
    }
}
