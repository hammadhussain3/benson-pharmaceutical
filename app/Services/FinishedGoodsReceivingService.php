<?php

namespace App\Services;

use App\Models\FinishedGoodsReceiving;

class FinishedGoodsReceivingService
{
    public function getAllFinishedGoodsReceivings()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $finishedGoodsReceivings = FinishedGoodsReceiving::orderBy('created_at', 'asc')->get();
        } else {
            $finishedGoodsReceivings = FinishedGoodsReceiving::where('company_id', auth()->user()->employee->company_id)->orderBy('created_at', 'asc')->get();
        }
        return $finishedGoodsReceivings;
    }

    public function createFinishedGoodsReceiving(array $data)
    {
        $items = $data['items'] ?? [];

        $data['batch_id'] = $data['batch'];
        $data['product_id'] = $data['product'];
        $data['company_id'] = $data['company'];

        $finishedGoodsReceiving = FinishedGoodsReceiving::create($data);

        foreach ($items as $item) {
            $item['product_variation_id'] = $item['product_variation'];

            $finishedGoodsReceiving->items()->create($item);
            $item['quantity'] = $item['quantity_received'];
            $item['product_id'] = $data['product_id'];
            $item['company_id'] = $data['company_id'];
            $finishedGoodsReceiving->stocks()->create($item);
        }

        return $finishedGoodsReceiving;
    }

    public function updateFinishedGoodsReceiving(FinishedGoodsReceiving $finishedGoodsReceiving, array $data)
    {
        $items = $data['items'] ?? [];

        $data['batch_id'] = $data['batch'];
        $data['product_id'] = $data['product'];
        $data['company_id'] = $data['company'];

        $finishedGoodsReceiving->update($data);

        $finishedGoodsReceiving->items()->delete();
        $finishedGoodsReceiving->stocks()->delete();

        foreach ($items as $item) {
            $item['product_variation_id'] = $item['product_variation'];

            $finishedGoodsReceiving->items()->create($item);
            $item['quantity'] = $item['quantity_received'];
            $item['product_id'] = $data['product_id'];
            $item['company_id'] = $data['company_id'];
            $finishedGoodsReceiving->stocks()->create($item);
        }

        return $finishedGoodsReceiving;
    }

    public function deleteFinishedGoodsReceiving(FinishedGoodsReceiving $finishedGoodsReceiving)
    {
        $finishedGoodsReceiving->stocks()->delete();
        return $finishedGoodsReceiving->delete();
    }

    public function getFinishedGoodsReceivingById($id)
    {
        return FinishedGoodsReceiving::findOrFail($id);
    }
}