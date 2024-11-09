<?php

namespace App\Services;

use App\Models\PackForm;

class PackFormsService
{
    public function getAllPackForms()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $packForms = PackForm::orderBy('name', 'asc')->get();
        } else {
            $packForms = PackForm::where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $packForms;
    }

    public function createPackForm(array $data)
    {
        $data['company_id'] = $data['company'];
        return PackForm::create($data);
    }

    public function updatePackForm(PackForm $packForm, array $data)
    {
        $data['company_id'] = $data['company'];
        $packForm->update($data);
        return $packForm;
    }

    public function deletePackForm(PackForm $packForm)
    {
        return $packForm->delete();
    }

    public function getPackFormById($id)
    {
        return PackForm::findOrFail($id);
    }
}