<?php

namespace App\Services;

use App\Models\Stock;

class StockService
{
    public function getAllStocks()
    {
        $stockQuery = Stock::with('product', 'company', 'rawMaterialItem')
            ->join('products', 'stocks.product_id', '=', 'products.id')
            ->join('companies', 'stocks.company_id', '=', 'companies.id')
            ->join('raw_material_items', 'stocks.company_id', '=', 'raw_material_items.id')
            ->orderBy('products.name', 'asc')
            ->select(
                'stocks.*', 
                'products.name as product_name', 
                'companies.name as company_name',
                'raw_material_items.name as raw_material_item_name',
            );

        if (!auth()->user()->hasRole('Superadmin')) {
            $stockQuery->where('stocks.company_id', auth()->user()->employee->company_id);
        }

        $stocks = $stockQuery->get();

        return $stocks;
    }

    public function createStock(array $data)
    {
        $data['product_id'] = $data['product'];
        $data['raw_material_item_id'] = $data['raw_material_item'];
        $data['company_id'] = $data['company'];
        return Stock::create($data);
    }

    public function updateStock(Stock $stock, array $data)
    {
        $data['product_id'] = $data['product'];
        $data['raw_material_item_id'] = $data['raw_material_item'];
        $data['company_id'] = $data['company'];
        $stock->update($data);
        return $stock;
    }

    public function deleteStock(Stock $stock)
    {
        return $stock->delete();
    }

    public function getStockById($id)
    {
        return Stock::findOrFail($id);
    }
}