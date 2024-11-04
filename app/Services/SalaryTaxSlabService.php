<?php

namespace App\Services;

use App\Models\SalaryTaxSlab;

class SalaryTaxSlabService
{
    public function getAllSlabs()
    {
        $salaryTaxSlabsQuery = SalaryTaxSlab::query();

        if (!auth()->user()->hasRole('Superadmin')) {
            $salaryTaxSlabsQuery->where('company_id', auth()->user()->employee->company_id);
        }

        $salaryTaxSlabs = $salaryTaxSlabsQuery->get();

        return $salaryTaxSlabs;
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
    public function getSlabById($id)
    {
        return SalaryTaxSlab::findOrFail($id);
    }
}