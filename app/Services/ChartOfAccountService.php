<?php

namespace App\Services;

use App\Models\ChartOfAccount;

class ChartOfAccountService
{
    public function createChartOfAccount($data)
    {
        return ChartOfAccount::create($data);
    }

    public function updateChartOfAccount(ChartOfAccount $chartOfAccount, $data)
    {
        return $chartOfAccount->update($data);
    }

    public function deleteChartOfAccount(ChartOfAccount $chartOfAccount)
    {
        return $chartOfAccount->delete();
    }
    // In ChartOfAccountService.php
    public function getAllChartOfAccounts()
    {
        return ChartOfAccount::all(); // Or implement pagination as needed
    }
}
