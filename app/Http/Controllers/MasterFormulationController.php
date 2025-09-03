<?php

namespace App\Http\Controllers;

use App\Models\MasterFormulation;
use App\Http\Requests\MasterFormulationRequest;

use App\Services\MasterFormulationService;
use App\Services\ProductService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterFormulationController extends Controller
{
    protected $masterFormulationService;
    protected $productService;
    public function __construct(
        MasterFormulationService $masterFormulationService,
        ProductService $productService
    ) {
        $this->masterFormulationService = $masterFormulationService;
        $this->productService = $productService;
    }

    public function index()
    {
        $masterFormulations = $this->masterFormulationService->getAllMasterFormulations();
        return view('admin.master-formulations.index', compact('masterFormulations'));
    }

    public function create()
    {
        $brandNames = $this->productService->getDistinctBrandNames();
        
        return view('admin.master-formulations.create', compact('brandNames'));
    }

    public function store(MasterFormulationRequest $request)
    {
        $this->masterFormulationService->createMasterFormulation($request->validated());
        return redirect()->route('master-formulations.index')->with('success', 'Master Formulation created successfully.');
    }

    public function show($id)
    {
        $masterFormulation = $this->masterFormulationService->getMasterFormulationById($id);
        return view('admin.master-formulations.show', compact('masterFormulation'));
    }

    public function edit($id)
    {
        $masterFormulation = $this->masterFormulationService->getMasterFormulationById($id);
        $brandNames = $this->productService->getDistinctBrandNames();
        
        return view('admin.master-formulations.edit', compact('masterFormulation', 'brandNames'));
    }

    public function update(MasterFormulationRequest $request, MasterFormulation $masterFormulation)
    {
        $this->masterFormulationService->updateMasterFormulation($masterFormulation, $request->validated());
        return redirect()->route('master-formulations.index')->with('success', 'Master Formulation updated successfully.');
    }

    public function destroy(MasterFormulation $masterFormulation)
    {
        $this->masterFormulationService->deleteMasterFormulation($masterFormulation);
        return redirect()->route('master-formulations.index')->with('success', 'Master Formulation deleted successfully.');
    }
}
