<?php

namespace App\Services;

use App\Models\SalarySlip;

class SalarySlipService
{
    public function createSalarySlip(array $data)
    {
        return SalarySlip::create($data);
    }

    public function updateSalarySlip(SalarySlip $salarySlip, array $data)
    {
        $salarySlip->update($data);
    }
}
