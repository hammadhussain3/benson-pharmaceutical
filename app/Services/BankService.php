<?php

namespace App\Services;

use App\Models\Bank;
use Illuminate\Validation\ValidationException;

class BankService
{
    public function getAllBanks()
    {
        return Bank::orderBy('name', 'asc')->get();
    }

    public function createBank(array $data)
    {
        $data['country_id'] = $data['country'];

        $existingBank = Bank::where('name', $data['name'])->first();
        if ($existingBank) {
            throw ValidationException::withMessages(['name' => 'The bank name must be unique.']);
        }
    
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

    public function getBankById($id)
    {
        return Bank::findOrFail($id);
    }
}
