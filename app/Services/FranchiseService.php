<?php

namespace App\Services;

use App\Models\Franchise;

class FranchiseService
{
    public function getAllFranchises()
    {
        return Franchise::with(['city', 'paymentType', 'country'])->orderBy('name', 'asc')->get();
    }

    public function createFranchise(array $data)
    {
        $data['country_id'] = $data['country'];
        $data['city_id'] = $data['city'];
        $data['payment_type_id'] = $data['payment_type'];
        return Franchise::create($data);
    }

    public function updateFranchise(Franchise $franchise, array $data)
    {
        $data['country_id'] = $data['country'];
        $data['city_id'] = $data['city'];
        $data['payment_type_id'] = $data['payment_type'];
        $franchise->update($data);
        return $franchise;
    }

    public function deleteFranchise(Franchise $franchise)
    {
        return $franchise->delete();
    }

    public function getFranchiseById($id)
    {
        return Franchise::findOrFail($id);
    }
}