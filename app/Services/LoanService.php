<?php

namespace App\Services;

use App\Models\Loan;

class LoanService
{
    public function createLoan(array $data)
    {
        return Loan::create($data);
    }

    public function updateLoan(Loan $loan, array $data)
    {
        $loan->update($data);
    }
}
