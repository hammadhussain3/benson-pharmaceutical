<?php

namespace App\Services;

use App\Models\Supplier;

class SupplierService
{
    public function getAllSuppliers()
    {
        return Supplier::with(['city', 'paymentType', 'country'])->orderBy('name', 'asc')->get();
    }

    public function createSupplier(array $data)
    {
        $data['country_id'] = $data['country'];
        $data['city_id'] = $data['city'];
        $data['payment_type_id'] = $data['payment_type'];
        return Supplier::create($data);
    }

    public function updateSupplier(Supplier $supplier, array $data)
    {
        $data['country_id'] = $data['country'];
        $data['city_id'] = $data['city'];
        $data['payment_type_id'] = $data['payment_type'];
        $supplier->update($data);
        return $supplier;
    }

    public function deleteSupplier(Supplier $supplier)
    {
        return $supplier->delete();
    }

    public function getSupplierById($id)
    {
        return Supplier::findOrFail($id);
    }
}