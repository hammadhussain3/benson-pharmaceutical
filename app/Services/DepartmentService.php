<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Validation\ValidationException;

class DepartmentService
{
    public function getAllDepartments()
    {
        return Department::orderBy('name', 'asc')->get();
    }

    public function createDepartment(array $data)
    {
        return Department::create($data);
    }

    public function updateDepartment(Department $department, array $data)
    {
        $department->update($data);
        return $department;
    }

    public function deleteDepartment(Department $department)
    {
        $department->delete();
    }

    public function validateDepartment(array $data)
    {
        $validator = \Validator::make($data, [
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
