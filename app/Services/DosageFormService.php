<?php

namespace App\Services;

use App\Models\DosageForm;

class DosageFormService
{
    public function getAllDosageForms()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $dosageForm = DosageForm::orderBy('name', 'asc')->get();
        } else {
            $dosageForm = DosageForm::where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $dosageForm;
    }

    public function createDosageForm(array $data)
    {
        $data['company_id'] = $data['company'];
        return DosageForm::create($data);
    }

    public function updateDosageForm(DosageForm $dosageForm, array $data)
    {
        $data['company_id'] = $data['company'];
        $dosageForm->update($data);
        return $dosageForm;
    }

    public function deleteDosageForm(DosageForm $dosageForm)
    {
        return $dosageForm->delete();
    }

    public function getDosageFormById($id)
    {
        return DosageForm::findOrFail($id);
    }
}
