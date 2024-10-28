<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Company;
use App\Http\Requests\DesignationRequest;
use App\Services\DesignationService;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    protected $designationService;

    public function __construct(DesignationService $designationService)
    {
        $this->designationService = $designationService;
    }

    public function index()
    {
        $designations = $this->designationService->getAllDesignations();
        return view('admin.designations.index', compact('designations'));
    }

    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.designations.create', compact('companies'));
    }

    public function store(DesignationRequest $request)
    {
        $this->designationService->createDesignation($request->validated());
        return redirect()->route('designations.index')->with('success', 'Designation created successfully.');
    }

    public function edit(Designation $designation)
    {
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.designations.edit', compact('designation', 'companies'));
    }

    public function update(DesignationRequest $request, Designation $designation)
    {
        $this->designationService->updateDesignation($designation, $request->validated());
        return redirect()->route('designations.index')->with('success', 'Designation updated successfully.');
    }

    public function destroy(Designation $designation)
    {
        $this->designationService->deleteDesignation($designation);
        return redirect()->route('designations.index')->with('success', 'Designation deleted successfully.');
    }
}
