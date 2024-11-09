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

    public function getAllChartOfAccounts()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $chartOfAccount = ChartOfAccount::orderBy('name', 'asc')->get();
        } else {
            $chartOfAccount = ChartOfAccount::where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $chartOfAccount;
    }

    public function getChartOfAccountById($id)
    {
        return ChartOfAccount::findOrFail($id);
    }
}
