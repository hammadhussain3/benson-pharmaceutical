<?php

namespace App\Http\Controllers;

use App\Models\EmployeeType;
use App\Services\CompanyService;
use App\Services\EmployeeTypeService;
use App\Http\Requests\EmployeeTypeResquest;

class EmployeeTypeController extends Controller
{
    protected $employeeTypeService;
    protected $companyService;

    public function __construct(EmployeeTypeService $employeeTypeService, CompanyService $companyService)
    {
        $this->employeeTypeService = $employeeTypeService;
        $this->companyService = $companyService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('Employee Type List')) {
            abort(403, 'Unauthorized action.');
        }
        $employeeTypes = $this->employeeTypeService->getAllEmployeeTypes();
        return view('admin.employee-types.index', compact('employeeTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('Employee Type View')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllCompanies();
        return view('admin.employee-types.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeTypeResquest $request)
    {
        if (!auth()->user()->hasPermission('Employee Type Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->employeeTypeService->createEmployeeType($request->validated());
        return redirect()->route('employee-types.index')->with('success', 'Employee type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeType $employeeType)
    {
        if (!auth()->user()->hasPermission('Employee Type View')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.employee-types.view', compact('employeeType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeType $employeeType)
    {
        if (!auth()->user()->hasPermission('Employee Type Update')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllCompanies();
        return view('admin.employee-types.edit', compact('employeeType', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeTypeResquest $request, EmployeeType $employeeType)
    {
        if (!auth()->user()->hasPermission('Employee Type Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->employeeTypeService->updateEmployeeType($employeeType, $request->validated());
        return redirect()->route('employee-types.index')->with('success', 'Employee type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeType $employeeType)
    {
        if (!auth()->user()->hasPermission('Employee Type Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->employeeTypeService->deleteEmployeeType($employeeType);
        return redirect()->route('employee-types.index')->with('success', 'Employee type deleted successfully.');
    }

    public function getEmployeeTypesByCompany($companyId)
    {
        $employeeTypes = EmployeeType::where('company_id', $companyId)->orderBy('type', 'asc')->get();
        return response()->json(['employeeTypes' => $employeeTypes]);
    }
}
