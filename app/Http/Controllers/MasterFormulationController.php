<?php

namespace App\Http\Controllers;

use App\Models\MasterFormulation;
use App\Http\Requests\MasterFormulationRequest;

use App\Services\MasterFormulationService;
use App\Services\ProductService;
use App\Models\Product;

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
        if (!auth()->user()->hasPermission('Master Formulation List')) {
            abort(403, 'Unauthorized action.');
        }
        $masterFormulations = $this->masterFormulationService->getAllMasterFormulations();
        if (request()->ajax()) {
            return response()->json([
                'master_formulations' => $masterFormulations,
            ]);
        }
        return view('admin.master-formulations.index', compact('masterFormulations'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Master Formulation Create')) {
            abort(403, 'Unauthorized action.');
        }
        $brandNames = $this->productService->getDistinctBrandNames();
        
        return view('admin.master-formulations.create', compact('brandNames'));
    }

    public function store(MasterFormulationRequest $request)
    {
        if (!auth()->user()->hasPermission('Master Formulation Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->masterFormulationService->createMasterFormulation($request->validated());
        return redirect()->route('master-formulations.index')->with('success', 'Master Formulation created successfully.');
    }

    public function show($id)
    {
        if (!auth()->user()->hasPermission('Master Formulation View')) {
            abort(403, 'Unauthorized action.');
        }
        $masterFormulation = $this->masterFormulationService->getMasterFormulationById($id);
        return view('admin.master-formulations.show', compact('masterFormulation'));
    }

    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Master Formulation Update')) {
            abort(403, 'Unauthorized action.');
        }
        $masterFormulation = $this->masterFormulationService->getMasterFormulationById($id);
        $brandNames = $this->productService->getDistinctBrandNames();
        
        return view('admin.master-formulations.edit', compact('masterFormulation', 'brandNames'));
    }

    public function update(MasterFormulationRequest $request, MasterFormulation $masterFormulation)
    {
        if (!auth()->user()->hasPermission('Master Formulation Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->masterFormulationService->updateMasterFormulation($masterFormulation, $request->validated());
        return redirect()->route('master-formulations.index')->with('success', 'Master Formulation updated successfully.');
    }

    public function destroy(MasterFormulation $masterFormulation)
    {
        if (!auth()->user()->hasPermission('Master Formulation Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->masterFormulationService->deleteMasterFormulation($masterFormulation);
        return redirect()->route('master-formulations.index')->with('success', 'Master Formulation deleted successfully.');
    }

    public function getMasterFormulationsByProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $brandName = $product->brand_name;

        $items = MasterFormulation::where('brand_name', $brandName)
            ->orderBy('product_name')
            ->get(['id', 'product_name', 'batch_size']);

        return response()->json([
            'brand_name' => $brandName,
            'products' => $items,
        ]);
    }

    public function getDetails($id)
    {
        $mf = MasterFormulation::findOrFail($id, ['id', 'product_name', 'batch_size']);
        return response()->json([
            'id' => $mf->id,
            'product_name' => $mf->product_name,
            'batch_size' => $mf->batch_size,
        ]);
    }
}
