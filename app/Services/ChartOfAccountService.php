<?php

namespace App\Services;

use App\Models\ChartOfAccount;

class ChartOfAccountService
{
    public function createChartOfAccount($data)
    {
        $data['company_id'] = $data['company'];
        return ChartOfAccount::create($data);
    }

    public function updateChartOfAccount(ChartOfAccount $chartOfAccount, $data)
    {
        $data['company_id'] = $data['company'];
        return $chartOfAccount->update($data);
    }

    public function deleteChartOfAccount(ChartOfAccount $chartOfAccount)
    {
        return $chartOfAccount->delete();
    }
    // In ChartOfAccountService.php
    public function getAllChartOfAccounts()
    {
        return ChartOfAccount::orderBy('name', 'asc')->get(); // Or implement pagination as needed
    }
}
