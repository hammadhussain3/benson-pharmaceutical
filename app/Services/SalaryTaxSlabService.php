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
        return SalaryTaxSlab::create($data);
    }

    public function updateSlab(SalaryTaxSlab $slab, array $data)
    {
        $slab->update($data);
        return $slab;
    }

    public function deleteSlab(SalaryTaxSlab $slab)
    {
        return $slab->delete();
    }
}
