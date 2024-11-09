<?php

namespace App\Services;

use App\Models\PackSize;

class PackSizeService
{
    public function getAllPackSize()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $packSize = PackSize::orderBy('name', 'asc')->get();
        } else {
            $packSize = PackSize::where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $packSize;
    }

    public function createPackSize(array $data)
    {
        $data['company_id'] = $data['company'];
        return PackSize::create($data);
    }

    public function updatePackSize(PackSize $packsize, array $data)
    {
        $data['company_id'] = $data['company'];
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
