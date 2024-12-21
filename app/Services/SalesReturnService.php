<?php

namespace App\Services;

use App\Models\SalesReturn;
use App\Models\SalesReturnItem;

class SalesReturnService
{
    public function getAll()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $salesReturns = SalesReturn::orderBy('created_at', 'asc')->get();
        } else {
            $salesReturns = SalesReturn::where('company_id', auth()->user()->employee->company_id)->orderBy('created_at', 'asc')->get();
        }
        return $salesReturns;
    }

    public function create(array $data)
    {
        $items = $data['items'] ?? [];

        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];

        $salesReturn = SalesReturn::create($data);

        foreach ($items as $value) {
            $value['product_variation_id'] = $value['product'];
            $value['batch_id'] = $value['batch'];

            $salesReturn->items()->create($value);
            $value['company_id'] = $data['company_id'];
            $value['total'] = $value['total_amount'];
            $salesReturn->stocks()->create($value);
        }

        return $salesReturn;
    }

    public function update(SalesReturn $salesReturn, array $data)
    {
        $items = $data['items'] ?? [];

        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];

        $salesReturn->update($data);
        $salesReturn->items()->delete();
        $salesReturn->stocks()->delete();

        foreach ($items as $value) {
            $value['product_variation_id'] = $value['product'];
            $value['batch_id'] = $value['batch'];

            $salesReturn->items()->create($value);
            $value['company_id'] = $data['company_id'];
            $value['total'] = $value['total_amount'];
            $salesReturn->stocks()->create($value);
        }
        
        return $salesReturn;        
    }

    public function delete(SalesReturn $salesReturn)
    {
        $salesReturn->stocks()->delete();
        return $salesReturn->delete();
    }

    public function getById($id)
    {
        return SalesReturn::findOrFail($id);
    }

    public function createCode($company_id)
    {
        $lastSalesReturnCode = SalesReturn::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastSalesReturnCode) {
            $numberPart = (int) substr($lastSalesReturnCode, 2);
            $newNumberPart = $numberPart + 1;
            $newSalesReturnCode = 'SR' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newSalesReturnCode = 'SR00001';
        }
        return $newSalesReturnCode;
    }
}