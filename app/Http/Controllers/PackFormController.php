<?php

namespace App\Http\Controllers;

use App\Models\PackForm;
use App\Http\Requests\PackFormRequest;
use App\Services\CompanyService;
use App\Services\PackFormsService;

class PackFormController extends Controller
{
    protected $companyService;
    protected $packFormService;

    public function __construct(PackFormsService $packFormService, CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->packFormService = $packFormService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('PackForm List')) {
            abort(403, 'Unauthorized action.');
        }
        $packForms = $this->packFormService->getAllPackForms();
        return view('admin.pack-form.index', compact('packForms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('PackForm Create')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllCompanies();
        return view('admin.pack-form.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackFormRequest $request)
    {
        if (!auth()->user()->hasPermission('PackForm Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->packFormService->createPackForm($request->validated());
        return redirect()->route('pack-forms.index')->with('success', 'PackForm created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermission('PackForm View')) {
            abort(403, 'Unauthorized action.');
        }
        $packForm = $this->packFormService->getPackFormById($id);
        return view('admin.pack-form.show', compact('packForm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermission('PackForm Update')) {
            abort(403, 'Unauthorized action.');
        }
        $packForm = $this->packFormService->getPackFormById($id);
        $companies = $this->companyService->getAllCompanies();
        return view('admin.pack-form.edit', compact('packForm','companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackFormRequest $request, PackForm $packForm)
    {
        if (!auth()->user()->hasPermission('PackForm Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->packFormService->updatePackForm($packForm, $request->validated());
        return redirect()->route('pack-forms.index')->with('success', 'PackForm updated successfully');
    }

    public function destroy(PackForm $packForm)
    {
        if (!auth()->user()->hasPermission('PackForm Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->packFormService->deletePackForm($packForm);
        return redirect()->route('pack-forms.index')->with('success', 'PackForm deleted successfully');
    }

    public function getPackFormsByCompany($companyId)
    {
        $packForms = PackForm::where('company_id', $companyId)->orderBy('name', 'asc')->get();
        return response()->json(['packForms' => $packForms]);
    }
}
