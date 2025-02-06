<?php

namespace App\Services;

use App\Models\EmployeeType;

class EmployeeTypeService
{
    public function createEmployeeType(array $data)
    {
        $data['company_id'] = $data['company'];
        return EmployeeType::create($data);
    }

    public function updateEmployeeType(EmployeeType $employeeType, array $data)
    {
        $data['company_id'] = $data['company'];
        return $employeeType->update($data);
    }

    public function deleteEmployeeType(EmployeeType $employeeType)
    {
        return $employeeType->delete();
    }

    public function getAllEmployeeTypes()
    {
        $employeeTypesQuery = EmployeeType::orderBy('type', 'asc');

        if (!auth()->user()->hasRole('Superadmin')) {
            $employeeTypesQuery->where('company_id', auth()->user()->employee->company_id);
        }

        $employeeTypes = $employeeTypesQuery->get();

        return $employeeTypes;
    }

    public function getEmployeeTypeById($id)
    {
        return EmployeeType::findOrFail($id);
    }
}
