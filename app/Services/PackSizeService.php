<?php

namespace App\Services;

use App\Models\PackSize;

class PackSizeService
{
    public function getAllPackSize()
    {
        return PackSize::orderBy('name', 'asc')->get();
    }

    public function createPackSize(array $data)
    {
        $data['name'] = $data['name'];
        $data['company_id'] = $data['company'];
        $data['description'] = $data['description'];
        return PackSize::create($data);
    }

    public function updatePackSize(PackSize $packsize, array $data)
    {
        $data['name'] = $data['name'];
        $data['company_id'] = $data['company'];
        $data['description'] = $data['description'];
        $packsize->update($data);
        return $packsize;
    }

    public function deletePackSize(PackSize $packsize)
    {
        $packsize->delete();
        return true;
    }

    public function getPackSizeById($id)
    {
        return PackSize::findOrFail($id);
    }
}
