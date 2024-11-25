<?php

namespace App\Services;

use App\Models\Stock;

class StockService
{
    public function getAllStocks()
    {
        $stockQuery = Stock::onlyManualStock();

        if (!auth()->user()->hasRole('Superadmin')) {
            $stockQuery->where('stocks.company_id', auth()->user()->employee->company_id);
        }

        return $stockQuery->orderBy('name', 'asc')->get();
    }

    public function createStock(array $data)
    {
        if (str_starts_with($data['product'], 'product_')) {
            $data['product_id'] = str_replace('product_', '', $data['product']);
            $data['raw_material_item_id'] = null;
        } elseif (str_starts_with($data['product'], 'raw_')) {
            $data['raw_material_item_id'] = str_replace('raw_', '', $data['product']);
            $data['product_id'] = null;
        }
        $data['company_id'] = $data['company'];
        return Stock::create($data);
    }

    public function updateStock(Stock $stock, array $data)
    {
        if (str_starts_with($data['product'], 'product_')) {
            $data['product_id'] = str_replace('product_', '', $data['product']);
            $data['raw_material_item_id'] = null;
        } elseif (str_starts_with($data['product'], 'raw_')) {
            $data['raw_material_item_id'] = str_replace('raw_', '', $data['product']);
            $data['product_id'] = null;
        }
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