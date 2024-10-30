<?php

namespace App\Services;

use App\Models\SalaryTaxSlab;

class SalaryTaxSlabService
{
    public function getAllSlabs()
    {
        return SalaryTaxSlab::all();
    }

    public function createSlab(array $data)
    {
        $data['company_id'] = $data['company'];
        return SalaryTaxSlab::create($data);
    }

    public function updateSlab(SalaryTaxSlab $slab, array $data)
    {
        $data['company_id'] = $data['company'];
        $slab->update($data);
        return $slab;
    }

    public function deleteSlab(SalaryTaxSlab $slab)
    {
        return $slab->delete();
    }
}
