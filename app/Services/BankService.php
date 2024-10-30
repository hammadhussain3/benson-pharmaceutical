<?php

namespace App\Services;

use App\Models\Bank;

class BankService
{
    public function getAllBanks()
    {
        return Bank::orderBy('name', 'asc')->get();
    }

    public function createBank(array $data)
    {
        $data['country_id'] = $data['country'];
        return Bank::create($data);
    }

    public function updateBank(Bank $bank, array $data)
    {
        $data['country_id'] = $data['country'];
        $bank->update($data);
        return $bank;
    }

    public function deleteBank(Bank $bank)
    {
        return $bank->delete();
    }
}
