<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Company;
use App\Services\DepartmentService;
use App\Models\Department;
use App\Models\Branch;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Departments List')) {
            abort(403, 'Unauthorized action.');
        }
        $branch = Department::with('branch')->get();
        $departments = $this->departmentService->getAllDepartments();
        return view('admin.departments.index', compact('departments','branch'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('Departments View')) {
            abort(403, 'Unauthorized action.');
        }
        $department =  $this->departmentService->getDepartmentById($id);
        return view('admin.departments.view', compact('department'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Departments Create')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = Company::orderBy('name', 'asc')->get();
        $branches = Branch::orderBy('name', 'asc')->get();
        return view('admin.departments.create', compact('companies', 'branches'));
    }

    public function store(DepartmentRequest $request)
    {
        if (!auth()->user()->hasPermission('Departments Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->departmentService->createDepartment($request->validated());
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        if (!auth()->user()->hasPermission('Departments Update')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = Company::orderBy('name', 'asc')->get();
        $branches = Branch::where('company_id', $department->company_id)->orderBy('name', 'asc')->get();
        return view('admin.departments.edit', compact('department', 'companies', 'branches'));
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        if (!auth()->user()->hasPermission('Departments Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->departmentService->updateDepartment($department, $request->validated());
        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        if (!auth()->user()->hasPermission('Departments Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->departmentService->deleteDepartment($department);
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }

    public function getDepartmentsByCompany($companyId)
    {
        $departments = Department::where('company_id', $companyId)->get();
        return response()->json(['departments' => $departments]);
    }

    public function getDepartmentsByBranch($branchId)
    {
        $departments = Department::where('branch_id', $branchId)->get();
        return response()->json(['departments' => $departments]);
    }
}