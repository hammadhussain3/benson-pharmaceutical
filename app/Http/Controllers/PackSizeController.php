<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackSizeRequest;
use App\Models\Company;
use App\Models\PackSize;
use App\Services\PackSizeService;
use App\Services\CompanyService;

class PackSizeController extends Controller
{
    protected $companyService;
    protected $packsizeService;

    public function __construct(PackSizeService $packsizeservice, CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->packsizeService = $packsizeservice;
    }
    
    public function index()
    {
        if (!auth()->user()->hasPermission('PackSize List')) {
            abort(403, 'Unauthorized action.');
        }
        
        $pack_sizes = $this->packsizeService->getAllPackSize();
        return view('admin.pack_size.index', compact('pack_sizes'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('PackSize Create')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllCompanies();
        return view('admin.pack_size.create', compact('companies'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('PackSize View')) {
            abort(403, 'Unauthorized action.');
        }
        $pack_size = $this->packsizeService->getPackSizeById($id);
        return view('admin.pack_size.view', compact('pack_size'));
    }

    public function store(PackSizeRequest $request)
    {
        if (!auth()->user()->hasPermission('PackSize Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->packsizeService->createPackSize($request->validated());
        return redirect()->route('pack_size.index')->with('success', 'Pack Size created successfully!');
    }

    public function edit(PackSize $pack_size)
    {
        if (!auth()->user()->hasPermission('PackSize Update')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllCompanies();
        return view('admin.pack_size.edit', compact('pack_size','companies'));
    }

    public function update(PackSizeRequest $request, PackSize $pack_size)
    {
        if (!auth()->user()->hasPermission('PackSize Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->packsizeService->updatePackSize($pack_size, $request->validated());
        return redirect()->route('pack_size.index')->with('success', 'Pack Size updated successfully!');
    }

    public function destroy(PackSize $pack_size)
    {
        if (!auth()->user()->hasPermission('PackSize Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->packsizeService->deletePackSize($pack_size);
        return redirect()->route('pack_size.index')->with('success', 'Pack Size deleted successfully!');
    }

    public function getPackSizeByCompany($companyId)
    {
        $pack_size = PackSize::where('company_id', $companyId)->get();
        return response()->json(['categories' => $pack_size]);
    }

    public function getPackSizesByCompany($companyId)
    {
        $packSizes = PackSize::where('company_id', $companyId)->orderBy('name', 'asc')->get();
        return response()->json(['packSizes' => $packSizes]);
    }
}
