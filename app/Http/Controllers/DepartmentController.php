<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Company;
use App\Services\DepartmentService;
use App\Models\Department;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index()
    {
        $departments = $this->departmentService->getAllDepartments();
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('admin.departments.create', compact('companies'));
    }

    public function store(DepartmentRequest $request)
    {
        $this->departmentService->createDepartment($request->validated());
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        $companies = Company::all();
        return view('admin.departments.edit', compact('department', 'companies'));
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $this->departmentService->updateDepartment($department, $request->validated());
        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $this->departmentService->deleteDepartment($department);
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
