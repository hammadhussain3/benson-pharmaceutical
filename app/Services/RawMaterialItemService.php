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
        $data['code'] = $data['category_prefix'] . $data['sub_category_prefix'] . $data['code'];
        $data['party_id'] = $data['party'];
        $data['category_id'] = $data['category'];
        $data['sub_category_id'] = $data['sub_category'];
        $data['company_id'] = $data['company'];
        return RawMaterialItem::create($data);
    }

    public function updateRawMaterialItem(RawMaterialItem $rawMaterialItem, array $data)
    {
        $data['code'] = $data['category_prefix'] . $data['sub_category_prefix'] . $data['code'];
        $data['party_id'] = $data['party'];
        $data['category_id'] = $data['category'];
        $data['sub_category_id'] = $data['sub_category'];
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
        $lastRawMaterialItemCode = RawMaterialItem::latest('id')
            ->where('company_id', $company_id)
            ->value('code');

        if ($lastRawMaterialItemCode) {
            $parts = explode('-', $lastRawMaterialItemCode);
            $lastPart = array_pop($parts); // get last numeric part
            $numberPart = (int) $lastPart;
            $newNumberPart = str_pad($numberPart + 1, strlen($lastPart), '0', STR_PAD_LEFT);
            return $newNumberPart;
        } else {
            return '00001';
        }
    }
}