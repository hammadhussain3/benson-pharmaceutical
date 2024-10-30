<?php

namespace App\Services;

use App\Models\Designation;

class DesignationService
{
    public function getAllDesignations()
    {
        return Designation::with('company')->orderBy('name', 'asc')->get();
    }

    public function createDesignation(array $data)
    {
        $data['company_id'] = $data['company'];
        return Designation::create($data);
    }

    public function updateDesignation(Designation $designation, array $data)
    {
        $data['company_id'] = $data['company'];
        $designation->update($data);
        return $designation;
    }

    public function deleteDesignation(Designation $designation)
    {
        return $designation->delete();
    }
}
