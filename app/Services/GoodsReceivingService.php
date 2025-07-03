<?php

namespace App\Services;

use App\Models\GoodsReceiving;
use App\Models\GoodsReceivingItem;
use App\Models\Invoice;

class GoodsReceivingService
{
    public function getAllGoodsReceivings()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $goodsReceivings = GoodsReceiving::orderBy('created_at', 'desc')->get();
        } else {
            $goodsReceivings = GoodsReceiving::where('company_id', auth()->user()->employee->company_id)->orderBy('created_at', 'desc')->get();
        }
        return $goodsReceivings;
    }

    public function createGoodsReceiving(array $data)
    {
        $items = $data['items'] ?? [];
        
        $data['invoice_id'] = $data['invoice'];
        $data['party_id'] = $data['supplier'];
        $data['company_id'] = $data['company'];

        $goodsReceiving = GoodsReceiving::create($data);

        foreach ($items as $item) {
            $item['product_id'] = $item['product'] ?? null;
            $item['raw_material_item_id'] = $item['raw_material_item'] ?? null;
            
            if ($item['product_id']) {
                $item['last_goods_receiving_id'] = GoodsReceivingItem::where('product_id', $item['product_id'])
                    ->latest('id')
                    ->value('goods_receiving_id');
            } elseif ($item['raw_material_item_id']) {
                $item['last_goods_receiving_id'] = GoodsReceivingItem::where('raw_material_item_id', $item['raw_material_item_id'])
                    ->latest('id')
                    ->value('goods_receiving_id');
            }

            $goodsReceiving->items()->create($item);

            $item['quantity'] = $item['balance_receivable'];
            $item['total'] = $item['total_amount'];
            $item['company_id'] = $data['company_id'];

            $goodsReceiving->stocks()->create($item);
        }

        $allItemsMatch = $goodsReceiving->items->every(function ($item) {
            return $item->quantity_ordered == ($item->quantity_received + $item->balance_receivable);
        });

        return $goodsReceiving;
    }

    public function updateGoodsReceiving(GoodsReceiving $goodsReceiving, array $data)
    {
        $items = $data['items'] ?? [];

        $data['invoice_id'] = $data['invoice'];
        $data['party_id'] = $data['supplier'];
        $data['company_id'] = $data['company'];

        $goodsReceiving->update($data);

        $goodsReceiving->items()->delete();
        $goodsReceiving->stocks()->delete();

        foreach ($items as $item) {
            $item['product_id'] = $item['product'] ?? null; // Use null if 'product' key is not set
            $item['raw_material_item_id'] = $item['raw_material_item'] ?? null; // Use null if 'raw_material_item' key is not set
            $item['batch_id'] = $item['batch'] ?? null; // Use null if 'batch' key is not set

            if ($item['product_id']) {
                $item['last_goods_receiving_id'] = GoodsReceivingItem::where('product_id', $item['product_id'])
                    ->where('goods_receiving_id', '<', $goodsReceiving->id)
                    ->latest('id')
                    ->value('goods_receiving_id');
            } elseif ($item['raw_material_item_id']) {
                $item['last_goods_receiving_id'] = GoodsReceivingItem::where('raw_material_item_id', $item['raw_material_item_id'])
                    ->where('goods_receiving_id', '<', $goodsReceiving->id)
                    ->latest('id')
                    ->value('goods_receiving_id');
            }

            $goodsReceiving->items()->create($item);
            $item['quantity'] = $item['balance_receivable'];
            $item['total'] = $item['total_amount'];
            $item['company_id'] = $data['company_id'];
            $goodsReceiving->stocks()->create($item);
        }

        $allItemsMatch = $goodsReceiving->items->every(function ($item) {
            return $item->quantity_ordered == ($item->quantity_received + $item->balance_receivable);
        });

        return $goodsReceiving;
    }

    public function deleteGoodsReceiving(GoodsReceiving $goodsReceiving)
    {
        $goodsReceiving->stocks->each->delete();
        $goodsReceiving->items->each->delete();
        return $goodsReceiving->delete();
    }

    public function getGoodsReceivingById($id)
    {
        return GoodsReceiving::findOrFail($id);
    }

    public function createGoodsReceivingCode($company_id)
    {
        $lastGoodsReceivingCode = GoodsReceiving::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastGoodsReceivingCode) {
            $numberPart = (int) substr($lastGoodsReceivingCode, 3);
            $newNumberPart = $numberPart + 1;
            $newGoodsReceivingCode = 'GRN' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newGoodsReceivingCode = 'GRN00001';
        }
        return $newGoodsReceivingCode;
    }
}
