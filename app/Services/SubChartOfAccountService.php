<?php

namespace App\Services;

use App\Models\SubChartOfAccount;

class SubChartOfAccountService
{
    public function create($data)
    {
        $data['chart_of_account_id'] = $data['chart_of_account'];
        $data['company_id'] = $data['company'];
        return SubChartOfAccount::create($data);
    }

    public function update(SubChartOfAccount $subChartOfAccount, $data)
    {
        $data['chart_of_account_id'] = $data['chart_of_account'];
        $data['company_id'] = $data['company'];
        return $subChartOfAccount->update($data);
    }

    public function delete(SubChartOfAccount $subChartOfAccount)
    {
        return $subChartOfAccount->delete();
    }

    public function getAll()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $subChartOfAccount = SubChartOfAccount::orderBy('name', 'asc')->get();
        } else {
            $subChartOfAccount = SubChartOfAccount::where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $subChartOfAccount;
    }

    public function getById($id)
    {
        return SubChartOfAccount::findOrFail($id);
    }
}
