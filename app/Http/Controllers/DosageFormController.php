<?php

namespace App\Http\Controllers;

use App\Models\DosageForm;
use App\Http\Requests\DosageFormRequest;
use App\Services\DosageFormService;
use App\Services\CompanyService;

class DosageFormController extends Controller
{
    protected $companyService;
    protected $dosageFormService;

    public function __construct(DosageFormService $dosageFormService, CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->dosageFormService = $dosageFormService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Dosage Form List')) {
            abort(403, 'Unauthorized action.');
        }
        $dosageForms = $this->dosageFormService->getAllDosageForms();
        return view('admin.dosage-forms.index', compact('dosageForms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('Dosage Form Create')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllCompanies();
        return view('admin.dosage-forms.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DosageFormRequest $request)
    {
        if (!auth()->user()->hasPermission('Dosage Form Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->dosageFormService->createDosageForm($request->validated());
        return redirect()->route('dosage-forms.index')->with('success', 'DosageForm created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermission('Dosage Form View')) {
            abort(403, 'Unauthorized action.');
        }
        $dosageForm = $this->dosageFormService->getDosageFormById($id);
        return view('admin.dosage-forms.show', compact('dosageForm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Dosage Form Update')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllCompanies();
        $dosageForm = $this->dosageFormService->getDosageFormById($id);
        return view('admin.dosage-forms.edit', compact('dosageForm', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DosageFormRequest $request, DosageForm $dosageForm)
    {
        if (!auth()->user()->hasPermission('Dosage Form Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->dosageFormService->updateDosageForm($dosageForm, $request->validated());
        return redirect()->route('dosage-forms.index')->with('success', 'DosageForm updated successfully');
    }

    public function destroy(DosageForm $dosageForm)
    {
        if (!auth()->user()->hasPermission('Dosage Form Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->dosageFormService->deleteDosageForm($dosageForm);
        return redirect()->route('dosage-forms.index')->with('success', 'DosageForm deleted successfully');
    }

    public function getDosageFormsByCompany($companyId)
    {
        $dosageForms = DosageForm::where('company_id', $companyId)->orderBy('name', 'asc')->get();
        return response()->json(['dosageForms' => $dosageForms]);
    }
}
