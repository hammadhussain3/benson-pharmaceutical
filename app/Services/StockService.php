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

    public function stockBinCard($productId = null, $rawMaterialItemId = null, $productVariationId = null, $from_date, $to_date)
    {
        $query = Stock::query();

        if ($productId !== null) {
            $query->where('product_id', $productId);
        }
        if ($rawMaterialItemId !== null) {
            $query->where('raw_material_item_id', $rawMaterialItemId);
        }
        if ($productVariationId !== null) {
            $query->where('product_variation_id', $productVariationId);
        }

        $stockEntries = $query->whereBetween('created_at', [$from_date, $to_date])->orderBy('created_at', 'asc')->get();

        $balance = 0;
        $stockReport = [];

        foreach ($stockEntries as $entry) {
            $type = null;
            if ($entry->goods_receiving_id || $entry->finished_goods_receiving_id || $entry->left_over_note_id) {
                $type = 'received';
                $doc = $entry->goodsReceiving->code ?? $entry->finishedGoodsReceiving->code ?? $entry->leftOverNote->code;
                $balance += $entry->quantity;
            } elseif ($entry->store_issue_requisition_id) {
                $type = 'issued';
                $doc = $entry->storeIssueRequisition->code;
                $balance -= $entry->quantity;
            } elseif (
                is_null($entry->goods_receiving_id) &&
                is_null($entry->finished_goods_receiving_id) &&
                is_null($entry->store_issue_requisition_id) &&
                is_null($entry->left_over_note_id)
            ) {
                $type = 'received';
                $doc = 'OPN-BAL';
                $balance += $entry->quantity;
            }

            $stockReport[] = [
                'date' => $entry->created_at->format('d M, Y'),
                'type' => $type,
                'doc' => $doc,
                'quantity' => $entry->quantity,
                'unit_price' => $entry->unit_price,
                'total' => $entry->total,
                'balance_quantity' => $balance,
                'balance_unit_price' => $entry->unit_price,
                'balance_total' => $balance * $entry->unit_price,
            ];
        }

        return $stockReport;
    }


    public function currentBalanceReport()
    {
        $balances = Stock::currentBalance();

        $productDetails = Stock::leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('raw_material_items', 'stocks.raw_material_item_id', '=', 'raw_material_items.id')
            ->leftJoin('product_variations', 'stocks.product_variation_id', '=', 'product_variations.id')
            ->leftJoin('products as variation_products', 'product_variations.product_id', '=', 'variation_products.id')
            ->leftJoin('packing_types', 'product_variations.packing_type_id', '=', 'packing_types.id')
            ->leftJoin('pack_sizes', 'product_variations.pack_size_id', '=', 'pack_sizes.id')
            ->select(
                'stocks.product_id',
                'stocks.raw_material_item_id',
                'stocks.product_variation_id',
                'stocks.unit',
                'stocks.unit_price',
                'products.name as product_name',
                'raw_material_items.name as raw_material_item_name',
                'variation_products.name as product_variation_name',
                'packing_types.name as packing_type_name',
                'pack_sizes.name as pack_size_name',
                'products.code as product_code',
                'raw_material_items.code as raw_material_item_code',
                'variation_products.code as product_variation_code'
            )
            ->where(function ($query) {
                $query->whereNotNull('stocks.product_id')
                    ->orWhereNotNull('stocks.raw_material_item_id')
                    ->orWhereNotNull('stocks.product_variation_id');
            })
            // Subquery to get the most recent row for each product_id, raw_material_item_id, and product_variation_id
            ->whereIn('stocks.id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('stocks')
                    ->groupBy('product_id', 'raw_material_item_id', 'product_variation_id');
            })
            ->get()
            ->keyBy(function ($item) {
                return ($item->product_id ?? 'null') . '_' . ($item->raw_material_item_id ?? 'null') . '_' . ($item->product_variation_id ?? 'null');
            });

        if (!auth()->user()->hasRole('Superadmin')) {
            $productDetails->where('company_id', auth()->user()->employee->company_id);
        }

        // Step 3: Merge balances with product details
        foreach ($balances as &$balance) {
            // Generate a unique key to match with the product details
            $key = ($balance['product_id'] ?? 'null') . '_' . ($balance['raw_material_item_id'] ?? 'null') . '_' . ($balance['product_variation_id'] ?? 'null');

            // Get the corresponding product details
            $productDetail = $productDetails->get($key);

            // Add product details to the balance
            $balance['product_name'] = $productDetail->product_name ?? null;
            $balance['raw_material_item_name'] = $productDetail->raw_material_item_name ?? null;
            $balance['product_variation_name'] = $productDetail->product_variation_name ?? null;
            $balance['packing_type_name'] = $productDetail->packing_type_name ?? null;
            $balance['pack_size_name'] = $productDetail->pack_size_name ?? null;
            $balance['product_code'] = $productDetail->product_code ?? null;
            $balance['raw_material_item_code'] = $productDetail->raw_material_item_code ?? null;
            $balance['product_variation_code'] = $productDetail->product_variation_code ?? null;
            $balance['unit'] = $productDetail->unit ?? null;
            $balance['unit_price'] = $productDetail->unit_price ?? 0;
            $balance['total'] = $balance['balance'] * $balance['unit_price'];
        }

        return $balances;
    }
}