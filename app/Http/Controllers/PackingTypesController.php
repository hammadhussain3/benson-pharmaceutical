<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackingTypeRequest;
use App\Services\PackingTypeService;
use App\Services\CompanyService;
use App\Models\PackingType;

class PackingTypesController extends Controller
{
    protected $companyService;
    protected $packingtypeService;

    public function __construct(PackingTypeService $packingtypeService, CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->packingtypeService = $packingtypeService;
    }
    public function index()
    {
        if (!auth()->user()->hasPermission('PackingType List')) {
            abort(403, 'Unauthorized action.');
        }
        
        $packing_types = $this->packingtypeService->getAllPackingtypes();
        return view('admin.packing_types.index', compact('packing_types'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('PackingType Create')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllCompanies();
        return view('admin.packing_types.create', compact('companies'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('PackingType View')) {
            abort(403, 'Unauthorized action.');
        }
        $packing_type = $this->packingtypeService->getPackingTypeById($id);
        return view('admin.packing_types.view', compact('packing_type'));
    }

    public function store(PackingTypeRequest $request)
    {
        if (!auth()->user()->hasPermission('PackingType Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->packingtypeService->createPackingType($request->validated());
        return redirect()->route('packingtypes.index')->with('success', 'Packing Type created successfully!');
    }

    public function edit(PackingType $packing_types,$id)
    {
        if (!auth()->user()->hasPermission('PackingType Update')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllCompanies();
        $packingTypes = PackingType::findOrFail($id);
        return view('admin.packing_types.edit', compact('packingTypes','companies'));
    }

    public function update(PackingTypeRequest $request, PackingType $packing_types,$id)
    {
        if (!auth()->user()->hasPermission('PackingType Update')) {
            abort(403, 'Unauthorized action.');
        }
        $packingtype = PackingType::find($id); // Retrieve the existing record by ID

        // Check if the record exists
        if ($packingtype) {
            $packingtype->name = $request->name;
            $packingtype->company_id = $request->company;
            $packingtype->description = $request->description;
            
            $packingtype->save();  // Save the updated data
        }
        // $this->packingtypeService->updatePackingType($packing_types, $request->validated());
        return redirect()->route('packingtypes.index')->with('success', 'Packing Type updated successfully!');
    }

    public function destroy(PackingType $packing_types,$id)
    {
        if (!auth()->user()->hasPermission('PackingType Delete')) {
            abort(403, 'Unauthorized action.');
        }
        // Find the PackingTypes record by its ID
        $packingtype = PackingType::find($id);

        // Check if the record exists before trying to delete
        if ($packingtype) {
            $packingtype->delete();  // Delete the record
        }
        // $this->packingtypeService->deletePackingType($packing_types);
        return redirect()->route('packingtypes.index')->with('success', 'Packing Type deleted successfully!');
    }

    public function getPackingTypesByCompany($companyId)
    {
        $packingTypes = PackingType::where('company_id', $companyId)->orderBy('name', 'asc')->get();
        return response()->json(['packingTypes' => $packingTypes]);
    }
}
