<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Validation\ValidationException;

class DepartmentService
{
    public function getAllDepartments()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $department = Department::orderBy('name', 'asc')->get();
        } else {
            $department = Department::where('company_id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $department;
    }

    public function createDepartment(array $data)
    {
        $data['company_id'] = $data['company'];
        $data['branch_id'] = $data['branch'];
        return Department::create($data);
    }

    public function updateDepartment(Department $department, array $data)
    {
        $data['company_id'] = $data['company'];
        $data['branch_id'] = $data['branch'];
        $department->update($data);
        return $department;
    }

    public function deleteDepartment(Department $department)
    {
        $department->delete();
    }

    public function getDepartmentById($id)
    {
        return Department::findOrFail($id);
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