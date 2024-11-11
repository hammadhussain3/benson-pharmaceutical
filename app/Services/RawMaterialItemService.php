<?php

namespace App\Services;

use App\Models\RawMaterialItem;

class RawMaterialItemService
{
    public function getAllRawMaterialItems()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $rawMaterialItems = RawMaterialItem::orderBy('name', 'asc')->get();
        } else {
            $rawMaterialItems = RawMaterialItem::where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $rawMaterialItems;
    }

    public function createRawMaterialItem(array $data)
    {
        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];
        return RawMaterialItem::create($data);
    }

    public function updateRawMaterialItem(RawMaterialItem $rawMaterialItem, array $data)
    {
        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];
        $rawMaterialItem->update($data);
        return $rawMaterialItem;
    }

    public function deleteRawMaterialItem(RawMaterialItem $rawMaterialItem)
    {
        return $rawMaterialItem->delete();
    }

    public function getRawMaterialItemById($id)
    {
        return RawMaterialItem::findOrFail($id);
    }

    public function createRawMaterialItemCode($company_id)
    {
        $lastRawMaterialItemCode = RawMaterialItem::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastRawMaterialItemCode) {
            $numberPart = (int) substr($lastRawMaterialItemCode, 3);
            $newNumberPart = $numberPart + 1;
            $newRawMaterialItemCode = 'RMI' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newRawMaterialItemCode = 'RMI00001';
        }
        return $newRawMaterialItemCode;
    }
}