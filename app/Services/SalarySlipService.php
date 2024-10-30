<?php

namespace App\Services;

use App\Models\SalarySlip;
use App\Models\Loan;

class SalarySlipService
{
    public function createSalarySlip(array $data)
    {
        $date = \DateTime::createFromFormat('Y-m', $data['month']);
        
        $data['month'] = $date->format('m');
        $data['year'] = $date->format('Y');
        $data['employee_id'] = $data['employee'];
        $data['company_id'] = $data['company'];

        $loan = Loan::where('employee_id', $data['employee_id'])
                    ->orderBy('created_at', 'desc')
                    ->first();

        if ($loan) {
            $loanAmount = $loan->remaining - $data['loan_advance'];
            
            if ($loanAmount < 0) {
                throw new \Exception('Loan remaining cannot be negative after deduction.');
            }
            $loan->update(['remaining' => $loanAmount]);
        }

        return SalarySlip::create($data);
    }

    public function updateSalarySlip(SalarySlip $salarySlip, array $data)
    {
        $date = \DateTime::createFromFormat('Y-m', $data['month']);
    
        $data['month'] = $date->format('m');
        $data['year'] = $date->format('Y');
        $data['employee_id'] = $data['employee'];
        $data['company_id'] = $data['company'];

        $salarySlip->update($data);
    }
}
