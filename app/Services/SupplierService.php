<?php

namespace App\Services;

use App\Models\Party;

class SupplierService
{
    public function getAllSuppliers()
    {
        $suppliersQuery = Party::with(['city', 'paymentType', 'country'])->where('is_supplier', '1')->orderBy('name', 'asc');

        if (!auth()->user()->hasRole('Superadmin')) {
            $suppliersQuery->where('company_id', auth()->user()->employee->company_id);
        }

        $suppliers = $suppliersQuery->get();

        return $suppliers;
    }

    public function createSupplier(array $data)
    {
        $data['country_id'] = $data['country'];
        $data['city_id'] = $data['city'];
        $data['chart_of_account_id'] = $data['chart_of_account'];
        $data['sub_chart_of_account_id'] = $data['sub_chart_of_account'];
        $data['company_id'] = $data['company'];
        $data['payment_type_id'] = $data['payment_type'];
        $data['is_supplier'] = '1';
        $data['is_distributor'] = '0';
        return Party::create($data);
    }

    public function updateSupplier(Party $supplier, array $data)
    {
        $data['country_id'] = $data['country'];
        $data['city_id'] = $data['city'];
        $data['chart_of_account_id'] = $data['chart_of_account'];
        $data['sub_chart_of_account_id'] = $data['sub_chart_of_account'];
        $data['company_id'] = $data['company'];
        $data['payment_type_id'] = $data['payment_type'];
        $data['is_supplier'] = '1';
        $data['is_distributor'] = '0';
        $supplier->update($data);
        return $supplier;
    }

    public function deleteSupplier(Party $supplier)
    {
        return $supplier->delete();
    }

    public function getSupplierById($id)
    {
        return Party::findOrFail($id);
    }

    public function createSupplierCode($company_id)
    {
        $lastSupplierCode = Party::latest('id')->where('company_id', $company_id)->where('is_supplier', '1')->value('code');
        if ($lastSupplierCode) {
            $numberPart = (int) substr($lastSupplierCode, 3);
            $newNumberPart = $numberPart + 1;
            $newSupplierCode = 'SUP' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newSupplierCode = 'SUP00001';
        }
        return $newSupplierCode;
    }
}