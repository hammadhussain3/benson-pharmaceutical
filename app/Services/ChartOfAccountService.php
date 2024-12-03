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
            $chartOfAccount = ChartOfAccount::orderBy('particular', 'asc')->get();
        } else {
            $chartOfAccount = ChartOfAccount::where('company_id', auth()->user()->employee->company_id)->orderBy('particular', 'asc')->get();
        }
        return $chartOfAccount;
    }

    public function getChartOfAccountById($id)
    {
        return ChartOfAccount::findOrFail($id);
    }

    public function createChartOfAccountCode($company_id)
    {
        $lastChartOfAccountCode = ChartOfAccount::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastChartOfAccountCode) {
            $numberPart = (int) substr($lastChartOfAccountCode, 3);
            $newNumberPart = $numberPart + 1;
            $newChartOfAccountCode = 'COA' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newChartOfAccountCode = 'COA00001';
        }
        return $newChartOfAccountCode;
    }
}
