<?php

namespace App\Services;

use App\Models\Tax;

class TaxService
{
    public function getAllTaxes()
    {
        return Tax::orderBy('name', 'asc')->get();
    }

    public function createTax(array $data)
    {
        $data['company_id'] = $data['company'];
        return Tax::create($data);
    }

    public function updateTax(Tax $tax, array $data)
    {
        $data['company_id'] = $data['company'];
        $tax->update($data);
        return $tax;
    }

    public function deleteTax(Tax $tax)
    {
        return $tax->delete();
    }

    public function getTaxById($id)
    {
        return Tax::findOrFail($id);
    }
}
