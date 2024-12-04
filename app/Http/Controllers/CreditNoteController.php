<?php

namespace App\Http\Controllers;

use App\Models\CreditNote;
use App\Http\Requests\CreditNoteRequest;
use App\Services\CreditNoteService;
use App\Services\ChartOfAccountService;
use App\Services\CompanyService;
use App\Services\PartyService;

class CreditNoteController extends Controller
{
    protected $creditNoteService;
    protected $chartOfAccountService;
    protected $companyService;
    protected $partyService;

    public function __construct(CreditNoteService $creditNoteService, ChartOfAccountService $chartOfAccountService, CompanyService $companyService, PartyService $partyService)
    {
        $this->creditNoteService = $creditNoteService;
        $this->chartOfAccountService = $chartOfAccountService;
        $this->companyService = $companyService;
        $this->partyService = $partyService;
    }

    public function index()
    {
        $creditNotes = $this->creditNoteService->getAll();
        return view('admin.credit-notes.index', compact('creditNotes'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $newCreditNoteCode = "CN";
        } else {
            $newCreditNoteCode = $this->creditNoteService->createCode(auth()->user()->employee->company_id);
        }
        $companies = $this->companyService->getAllCompanies();
        $charOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        $parties = $this->partyService->getAllParties();
        return view('admin.credit-notes.create', compact('companies', 'charOfAccounts', 'parties', 'newCreditNoteCode'));
    }

    public function store(CreditNoteRequest $request)
    {
        $this->creditNoteService->create($request->validated());
        return redirect()->route('credit-notes.index')->with('success', 'Credit Note created successfully.');
    }

    public function show($id)
    {
        $creditNote = $this->creditNoteService->getById($id);
        return view('admin.credit-notes.show', compact('creditNote'));
    }

    public function edit($id)
    {
        $creditNote = $this->creditNoteService->getById($id);
        $companies = $this->companyService->getAllCompanies();
        $charOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        $parties = $this->partyService->getAllParties();
        return view('admin.credit-notes.edit', compact('creditNote', 'companies', 'charOfAccounts', 'parties'));
    }

    public function update(CreditNoteRequest $request, CreditNote $creditNote)
    {
        $this->creditNoteService->update($creditNote, $request->validated());
        return redirect()->route('credit-notes.index')->with('success', 'Credit Note updated successfully');
    }

    public function destroy(CreditNote $creditNote)
    {
        $this->creditNoteService->delete($creditNote);
        return redirect()->route('credit-notes.index')->with('success', 'Credit Note deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $credit_note_code = $this->creditNoteService->createCode($companyId);
        return response()->json(['credit_note_code' => $credit_note_code]);
    }
}
