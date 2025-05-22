<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\GoodsReceivingItem;
use App\Models\FinishedGoodsReceivingItem;
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

    public function getPriceByProductVariationId($productVariationId)
    {
        $raw_material_item = null;
        $product_variation = null;
        $balance = 0;
        $unit = null;
        $average_price = 0;

        if (str_starts_with($productVariationId, 'raw_')) {
            $raw_material_item = (int) str_replace('raw_', '', $productVariationId);
            $stock = Stock::currentBalanceForItem(null, $raw_material_item);
            $balance = $stock['balance'] ?? 0;

            $items = GoodsReceivingItem::where('raw_material_item_id', $raw_material_item)
                ->orderByDesc('id')
                ->get();

        } elseif (str_starts_with($productVariationId, 'var_')) {
            $product_variation = (int) str_replace('var_', '', $productVariationId);
            $stock = Stock::currentBalanceForItem(null, null, $product_variation);
            $balance = $stock['balance'] ?? 0;

            $items = FinishedGoodsReceivingItem::where('product_variation_id', $product_variation)
                ->orderByDesc('id')
                ->get();

        } else {
            return response()->json([
                'error' => 'Invalid product variation ID format.'
            ], 400);
        }

        // Pick latest rows until balance is covered
        $accumulatedQty = 0;
        $totalCost = 0;

        foreach ($items as $item) {
            $qty = $item->quantity_received ?? 0;
            $price = $item->unit_price ?? 0;

            if ($accumulatedQty + $qty <= $balance) {
                $accumulatedQty += $qty;
                $totalCost += $qty * $price;
            } else {
                $needed = $balance - $accumulatedQty;
                $accumulatedQty += $needed;
                $totalCost += $needed * $price;
                break;
            }

            $unit = $item->unit ?? $unit;
        }

        $average_price = $accumulatedQty > 0 ? round($totalCost / $accumulatedQty, 2) : 0;

        return response()->json([
            'unit' => $unit ?? 'Unit',
            'price' => $average_price
        ]);
    }

}
