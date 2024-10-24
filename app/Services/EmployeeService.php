<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    public function createEmployee(array $data)
    {
        return Employee::create($data);
    }

    public function updateEmployee(Employee $employee, array $data)
    {
        $employee->update($data);
        return $employee;
    }

    public function deleteEmployee(Employee $employee)
    {
        return $employee->delete();
    }

    public function getAllEmployees()
    {
        return Employee::all();
    }

    public function getEmployeeById($id)
    {
        return Employee::findOrFail($id);
    }
}
