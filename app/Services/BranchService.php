<?php

namespace App\Services;

use App\Models\Branch;
use Illuminate\Validation\ValidationException;

class BranchService
{
    public function getAllBranches()
    {
        return Branch::orderBy('name', 'asc')->get();
    }

    public function createBranch(array $data)
    {
        return Branch::create($data);
    }

    public function updateBranch(Branch $branch, array $data)
    {
        $branch->update($data);
        return $branch;
    }

    public function deleteBranch(Branch $branch)
    {
        $branch->delete();
    }

    public function validateBranch(array $data)
    {
        $validator = \Validator::make($data, [
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|string|max:20|regex:/^(\+?\d{1,3}[- ]?)?\d{10,15}$/',
            'email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
