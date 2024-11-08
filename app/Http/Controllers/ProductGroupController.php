<?php

namespace App\Http\Controllers;

use App\Models\ProductGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductGroupRequest;
use App\Models\Company;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $productGroups = ProductGroup::paginate();

        return view('admin.product-group.index', compact('productGroups'))
            ->with('i', ($request->input('page', 1) - 1) * $productGroups->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $productGroup = new ProductGroup();
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.product-group.create', compact('productGroup','companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductGroupRequest $request): RedirectResponse
    {
        ProductGroup::create($request->validated());

        return Redirect::route('product-groups.index')
            ->with('success', 'ProductGroup created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $productGroup = ProductGroup::find($id);

        return view('admin.product-group.show', compact('productGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $productGroup = ProductGroup::find($id);
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.product-group.edit', compact('productGroup','companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductGroupRequest $request, ProductGroup $productGroup): RedirectResponse
    {
        $productGroup->update($request->validated());

        return Redirect::route('product-groups.index')
            ->with('success', 'ProductGroup updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        ProductGroup::find($id)->delete();

        return Redirect::route('product-groups.index')
            ->with('success', 'ProductGroup deleted successfully');
    }

    public function getProductGroupsByCompany($companyId)
    {
        $productGroups = ProductGroup::where('company_id', $companyId)->get();
        return response()->json(['productGroups' => $productGroups]);
    }
}
