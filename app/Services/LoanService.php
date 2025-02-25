<?php

namespace App\Services;

use App\Models\Loan;

class LoanService
{
    public function createLoan(array $data)
    {
        $created_at = now()->setDate($data['year'], $data['month'], now()->day);
        $data['employee_id'] = $data['employee'];
        $data['company_id'] = $data['company'];
        $data['created_at'] = $created_at;
        return Loan::create($data);
    }

    public function updateLoan(Loan $loan, array $data)
    {
        $created_at = now()->setDate($data['year'], $data['month'], now()->day);
        $data['employee_id'] = $data['employee'];
        $data['company_id'] = $data['company'];
        $data['created_at'] = $created_at;
        $loan->update($data);
    }
}
