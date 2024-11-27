<?php

namespace App\Services;

use App\Models\FinishedGoodsReceiving;
use App\Models\FinishedGoodsReceivingItem;
use App\Models\ProductVariation;

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

    public function createFinishedGoodsReceivingCode($company_id)
    {
        $lastFinishedGoodsReceivingCode = FinishedGoodsReceiving::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastFinishedGoodsReceivingCode) {
            $numberPart = (int) substr($lastFinishedGoodsReceivingCode, 3);
            $newNumberPart = $numberPart + 1;
            $newFinishedGoodsReceivingCode = 'FGR' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newFinishedGoodsReceivingCode = 'FGR00001';
        }
        return $newFinishedGoodsReceivingCode;
    }

    public function getMonthlyFinishedProductReport()
    {
        $finalProducts = ProductVariation::all();

        if (!auth()->user()->hasRole('Superadmin')) {
            $finalProducts = $finalProducts->where('company_id', auth()->user()->employee->company_id);
        }

        $finalProducts->each(function ($product) {
            $monthlyTotals = array_fill(1, 12, 0);

            $currentYear = now()->year;

            $finishedProducts = $product->finishedProducts()
                ->whereYear('created_at', $currentYear)
                ->select('created_at', 'quantity_received')
                ->get();

            $finishedProducts->each(function ($finishedProduct) use (&$monthlyTotals) {
                $month = $finishedProduct->created_at->month;
                $monthlyTotals[$month] += $finishedProduct->quantity_received;
            });

            $product->monthly_totals = $monthlyTotals;
        });

        return $finalProducts;
    }
}