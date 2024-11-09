<?php

namespace App\Services;

use App\Models\Branch;
use Illuminate\Validation\ValidationException;

class BranchService
{
    public function getAllBranches()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $branch = Branch::orderBy('name', 'asc')->get();
        } else {
            $branch = Branch::where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $branch;
    }

    public function createBranch(array $data)
    {
        $data['company_id'] = $data['company'];
        $data['country_id'] = $data['country'];
        $data['city_id'] = $data['city'];
        return Branch::create($data);
    }

    public function updateBranch(Branch $branch, array $data)
    {
        $data['company_id'] = $data['company'];
        $data['country_id'] = $data['country'];
        $data['city_id'] = $data['city'];
        $branch->update($data);
        return $branch;
    }

    public function deleteBranch(Branch $branch)
    {
        $branch->delete();
    }

    public function getBranchById($id)
    {
        return Branch::findOrFail($id);
    }

    public function validateBranch(array $data)
    {
        $validator = \Validator::make($data, [
            'company' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'country' => 'required|exists:countries,id',
            'city' => 'required|exists:cities,id',
            'phone' => 'required|string|max:20|regex:/^(\+?\d{1,3}[- ]?)?\d{10,15}$/',
            'email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
