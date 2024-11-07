<?php

namespace App\Services;

use App\Models\PackingTypes;

class PackingTypeService
{
    public function getAllPackingTypes()
    {
        return PackingTypes::orderBy('name', 'asc')->get();
    }

    public function createPackingType(array $data)
    {
        $data['name'] = $data['name'];
        $data['company_id'] = $data['company'];
        $data['description'] = $data['description'];
        return PackingTypes::create($data);
    }

    public function updatePackingType(PackingTypes $packing_types, array $data)
    {
        $data['name'] = $data['name'];
        $data['company_id'] = $data['company'];
        $data['description'] = $data['description'];
        $packing_types->update($data);
        return $packing_types;
    }

    public function deletePackingType(PackingTypes $packing_types)
    {
        $packing_types->delete();
        return true;
    }

    public function getPackingTypeById($id)
    {
        return PackingTypes::findOrFail($id);
    }
}
