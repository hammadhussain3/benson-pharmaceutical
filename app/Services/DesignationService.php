<?php

namespace App\Services;

use App\Models\Designation;

class DesignationService
{
    public function getAllDesignations()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $designation = Designation::with('company')->orderBy('name', 'asc')->get();
        } else {
            $designation = Designation::with('company')->where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        
        return $designation;
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
    public function getDesignationById($id)
{
    if (auth()->user()->hasRole('Superadmin')) {
        // Superadmin can access any designation by ID
        return Designation::with('company')->findOrFail($id);
    } else {
        // Other users are restricted to their company_id
        return Designation::with('company')
            ->where('company_id', auth()->user()->employee->company_id)
            ->findOrFail($id); // Only retrieves if it matches the ID and company_id
    }
}
}