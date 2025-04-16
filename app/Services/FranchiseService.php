<?php

namespace App\Services;

use App\Models\Party;

class FranchiseService
{
    public function getAllFranchises()
    {
        $franchisesQuery = Party::with(['city', 'paymentType', 'country'])->where('is_distributor', '1')->orderBy('name', 'asc');

        if (!auth()->user()->hasRole('Superadmin')) {
            $franchisesQuery->where('company_id', auth()->user()->employee->company_id);
        }

        $franchises = $franchisesQuery->get();

        return $franchises;
    }

    public function createFranchise(array $data)
    {
        $data['country_id'] = $data['country'];
        $data['city_id'] = $data['city'];
        $data['category_id'] = $data['category'];
        $data['sub_category_id'] = $data['sub_category'];
        $data['company_id'] = $data['company'];
        $data['payment_type_id'] = $data['payment_type'];
        $data['is_supplier'] = '0';
        $data['is_distributor'] = '1';
        return Party::create($data);
    }

    public function updateFranchise(Party $franchise, array $data)
    {
        $data['country_id'] = $data['country'];
        $data['city_id'] = $data['city'];
        $data['category_id'] = $data['category'];
        $data['sub_category_id'] = $data['sub_category'];
        $data['company_id'] = $data['company'];
        $data['payment_type_id'] = $data['payment_type'];
        $franchise->update($data);
        return $franchise;
    }

    public function deleteFranchise(Party $franchise)
    {
        return $franchise->delete();
    }

    public function getFranchiseById($id)
    {
        return Party::findOrFail($id);
    }

    public function createFranchiseCode($company_id)
    {
        $lastFranchiseCode = Party::latest('id')->where('company_id', $company_id)->where('is_distributor', '1')->value('code');
        if ($lastFranchiseCode) {
            $parts = explode('-', $lastFranchiseCode);
            $lastPart = array_pop($parts); // get last numeric part
            $numberPart = (int) $lastPart;
            $newNumberPart = str_pad($numberPart + 1, strlen($lastPart), '0', STR_PAD_LEFT);
            return $newNumberPart;
        } else {
            return '00001';
        }
    }
}