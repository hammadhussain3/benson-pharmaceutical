<?php

namespace App\Services;

use App\Models\PackingType;

class PackingTypeService
{
    public function getAllPackingTypes()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $packingType = PackingType::orderBy('name', 'asc')->get();
        } else {
            $packingType = PackingType::where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $packingType;
    }

    public function createPackingType(array $data)
    {
        $data['company_id'] = $data['company'];
        return PackingType::create($data);
    }

    public function updatePackingType(PackingType $packing_types, array $data)
    {
        $data['company_id'] = $data['company'];
        $packing_types->update($data);
        return $packing_types;
    }

    public function deletePackingType(PackingType $packing_types)
    {
        $packing_types->delete();
        return true;
    }

    public function getPackingTypeById($id)
    {
        return PackingType::findOrFail($id);
    }
}
