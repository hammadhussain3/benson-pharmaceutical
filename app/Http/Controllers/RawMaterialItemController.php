<?php

namespace App\Http\Controllers;

use App\Models\RawMaterialItem;
use App\Http\Requests\RawMaterialItemRequest;
use App\Services\RawMaterialItemService;
use App\Services\CompanyService;
use App\Services\PartyService;
use App\Services\CategoryService;

class RawMaterialItemController extends Controller
{
    protected $companyService;
    protected $rawMaterialItemService;
    protected $partyService;
    protected $categoryService;

    public function __construct(RawMaterialItemService $rawMaterialItemService, CompanyService $companyService, PartyService $partyService, CategoryService $categoryService)
    {
        $this->companyService = $companyService;
        $this->categoryService = $categoryService;
        $this->partyService = $partyService;
        $this->rawMaterialItemService = $rawMaterialItemService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Raw Material Item List')) {
            abort(403, 'Unauthorized action.');
        }
        $rawMaterialItems = $this->rawMaterialItemService->getAllRawMaterialItems();
        return view('admin.raw-material-items.index', compact('rawMaterialItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('Raw Material Item Create')) {
            abort(403, 'Unauthorized action.');
        }
        $newRawMaterialItemCode = null;
        if (!auth()->user()->hasRole('Superadmin')) {
            $newRawMaterialItemCode = $this->rawMaterialItemService->createRawMaterialItemCode(auth()->user()->employee->company_id);
        }
        $categories = $this->categoryService->getAllCategories();
        $companies = $this->companyService->getAllcompanies();
        $parties = $this->partyService->getAllParties();
        return view('admin.raw-material-items.create', compact('companies', 'parties', 'newRawMaterialItemCode', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RawMaterialItemRequest $request)
    {
        if (!auth()->user()->hasPermission('Raw Material Item Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->rawMaterialItemService->createRawMaterialItem($request->validated());
        return redirect()->route('raw-material-items.index')->with('success', 'Raw Material Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermission('Raw Material Item View')) {
            abort(403, 'Unauthorized action.');
        }
        $rawMaterialItem = $this->rawMaterialItemService->getRawMaterialItemById($id);
        return view('admin.raw-material-items.show', compact('rawMaterialItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Raw Material Item Update')) {
            abort(403, 'Unauthorized action.');
        }
        $rawMaterialItem = $this->rawMaterialItemService->getRawMaterialItemById($id);
        $categories = $this->categoryService->getAllCategories();
        $companies = $this->companyService->getAllcompanies();
        $parties = $this->partyService->getAllParties();
        return view('admin.raw-material-items.edit', compact('rawMaterialItem', 'companies', 'parties', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RawMaterialItemRequest $request, RawMaterialItem $rawMaterialItem)
    {
        if (!auth()->user()->hasPermission('Raw Material Item Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->rawMaterialItemService->updateRawMaterialItem($rawMaterialItem, $request->validated());
        return redirect()->route('raw-material-items.index')->with('success', 'Raw Material Item updated successfully');
    }

    public function destroy(RawMaterialItem $rawMaterialItem)
    {
        if (!auth()->user()->hasPermission('Raw Material Item Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->rawMaterialItemService->deleteRawMaterialItem($rawMaterialItem);
        return redirect()->route('raw-material-items.index')->with('success', 'Raw Material Item deleted successfully');
    }

    public function getRawMaterialItemsByCompany($companyId)
    {
        $rawMaterialItems = RawMaterialItem::where('company_id', $companyId)->orderBy('name', 'asc')->get();
        return response()->json(['rawMaterialItems' => $rawMaterialItems]);
    }

    public function createCodeByCompany($companyId)
    {
        $raw_material_item_code = $this->rawMaterialItemService->createRawMaterialItemCode($companyId);
        return response()->json(['raw_material_item_code' => $raw_material_item_code]);
    }
}