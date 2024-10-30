<?php

namespace App\Services;

use App\Models\Loan;

class LoanService
{
    public function createLoan(array $data)
    {
        $data['employee_id'] = $data['employee'];
        $data['company_id'] = $data['company'];
        return Loan::create($data);
    }

    public function updateLoan(Loan $loan, array $data)
    {
        $data['employee_id'] = $data['employee'];
        $data['company_id'] = $data['company'];
        $loan->update($data);
    }
}
