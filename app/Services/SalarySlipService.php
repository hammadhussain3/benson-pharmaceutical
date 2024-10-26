<?php

namespace App\Services;

use App\Models\SalarySlip;

class SalarySlipService
{
    public function createSalarySlip(array $data)
    {
        $date = \DateTime::createFromFormat('Y-m', $data['month']);
    
        $data['month'] = $date->format('m');
        $data['year'] = $date->format('Y');
        
        return SalarySlip::create($data);
    }

    public function updateSalarySlip(SalarySlip $salarySlip, array $data)
    {
        $date = \DateTime::createFromFormat('Y-m', $data['month']);
    
        $data['month'] = $date->format('m');
        $data['year'] = $date->format('Y');

        $salarySlip->update($data);
    }
}
