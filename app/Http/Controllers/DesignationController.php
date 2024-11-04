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
        if (!auth()->user()->hasPermission('Designation List')) {
            abort(403, 'Unauthorized action.');
        }
        $designations = $this->designationService->getAllDesignations();
        return view('admin.designations.index', compact('designations'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('Designation View')) {
            abort(403, 'Unauthorized action.');
        }
        $designations =  $this->designationService->getDesignationById($id);
        return view('admin.designations.view', compact('designations'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Designation Create')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.designations.create', compact('companies'));
    }

    public function store(DesignationRequest $request)
    {
        if (!auth()->user()->hasPermission('Designation Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->designationService->createDesignation($request->validated());
        return redirect()->route('designations.index')->with('success', 'Designation created successfully.');
    }

    public function edit(Designation $designation)
    {
        if (!auth()->user()->hasPermission('Designation Update')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.designations.edit', compact('designation', 'companies'));
    }

    public function update(DesignationRequest $request, Designation $designation)
    {
        if (!auth()->user()->hasPermission('Designation Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->designationService->updateDesignation($designation, $request->validated());
        return redirect()->route('designations.index')->with('success', 'Designation updated successfully.');
    }

    public function destroy(Designation $designation)
    {
        if (!auth()->user()->hasPermission('Designation Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->designationService->deleteDesignation($designation);
        return redirect()->route('designations.index')->with('success', 'Designation deleted successfully.');
    }

    public function getDesignationsByCompany($companyId)
    {
        if (!auth()->user()->hasPermission('Designation List')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }
        $designations = Designation::where('company_id', $companyId)->get();
        return response()->json(['designations' => $designations]);
    }
}