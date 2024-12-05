<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\StockRequest;
use App\Services\StockService;
use App\Services\CompanyService;
use App\Services\ProductService;
use App\Services\RawMaterialItemService;

class StockController extends Controller
{
    protected $companyService;
    protected $stockService;
    protected $productService;
    protected $rawMaterialItemService;

    public function __construct(StockService $stockService, CompanyService $companyService, ProductService $productService, RawMaterialItemService $rawMaterialItemService)
    {
        $this->companyService = $companyService;
        $this->stockService = $stockService;
        $this->productService = $productService;
        $this->rawMaterialItemService = $rawMaterialItemService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Stock List')) {
            abort(403, 'Unauthorized action.');
        }
        $stocks = $this->stockService->getAllStocks();
        return view('admin.stocks.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('Stock Create')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllcompanies();
        $products = $this->productService->getAllProducts();
        $rawMaterialItems = $this->rawMaterialItemService->getAllRawMaterialItems();
        return view('admin.stocks.create', compact('companies', 'products', 'rawMaterialItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockRequest $request)
    {
        if (!auth()->user()->hasPermission('Stock Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->stockService->createStock($request->validated());
        return redirect()->route('stocks.index')->with('success', 'Stock created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermission('Stock View')) {
            abort(403, 'Unauthorized action.');
        }
        $stock = $this->stockService->getStockById($id);
        return view('admin.stocks.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Stock Update')) {
            abort(403, 'Unauthorized action.');
        }
        $stock = $this->stockService->getStockById($id);
        $companies = $this->companyService->getAllcompanies();
        $products = $this->productService->getAllProducts();
        $rawMaterialItems = $this->rawMaterialItemService->getAllRawMaterialItems();
        return view('admin.stocks.edit', compact('stock', 'companies', 'products', 'rawMaterialItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StockRequest $request, Stock $stock)
    {
        if (!auth()->user()->hasPermission('Stock Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->stockService->updateStock($stock, $request->validated());
        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully');
    }

    public function destroy(Stock $stock)
    {
        if (!auth()->user()->hasPermission('Stock Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->stockService->deleteStock($stock);
        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully');
    }
}
