<?php

namespace App\Http\Controllers;

use App\Models\JournalVoucher;
use App\Http\Requests\JournalVoucherRequest;
use App\Services\JournalVoucherService;
use App\Services\ChartOfAccountService;
use App\Services\CompanyService;

class JournalVoucherController extends Controller
{
    protected $journalVoucherService;
    protected $chartOfAccountService;
    protected $companyService;

    public function __construct(JournalVoucherService $journalVoucherService, ChartOfAccountService $chartOfAccountService, CompanyService $companyService)
    {
        $this->journalVoucherService = $journalVoucherService;
        $this->chartOfAccountService = $chartOfAccountService;
        $this->companyService = $companyService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Journal Voucher List')) {
            abort(403, 'Unauthorized action.');
        }
        $journalVouchers = $this->journalVoucherService->getAll();
        return view('admin.journal-vouchers.index', compact('journalVouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('Journal Voucher Create')) {
            abort(403, 'Unauthorized action.');
        }
        if (auth()->user()->hasRole('Superadmin')) {
            $newJournalVoucherCode = "JV";
        } else {
            $newJournalVoucherCode = $this->journalVoucherService->createCode(auth()->user()->employee->company_id);
        }
        $companies = $this->companyService->getAllCompanies();
        $charOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        return view('admin.journal-vouchers.create', compact('companies', 'charOfAccounts', 'newJournalVoucherCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JournalVoucherRequest $request)
    {
        if (!auth()->user()->hasPermission('Journal Voucher Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->journalVoucherService->create($request->validated());
        return redirect()->route('journal-vouchers.index')->with('success', 'Journal Voucher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermission('Journal Voucher View')) {
            abort(403, 'Unauthorized action.');
        }
        $journalVoucher = $this->journalVoucherService->getById($id);
        return view('admin.journal-vouchers.show', compact('journalVoucher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Journal Voucher Update')) {
            abort(403, 'Unauthorized action.');
        }
        $journalVoucher = $this->journalVoucherService->getById($id);
        $companies = $this->companyService->getAllCompanies();
        $charOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        return view('admin.journal-vouchers.edit', compact('journalVoucher', 'companies', 'charOfAccounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JournalVoucherRequest $request, JournalVoucher $journalVoucher)
    {
        if (!auth()->user()->hasPermission('Journal Voucher Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->journalVoucherService->update($journalVoucher, $request->validated());
        return redirect()->route('journal-vouchers.index')->with('success', 'Journal Voucher updated successfully');
    }

    public function destroy(JournalVoucher $journalVoucher)
    {
        if (!auth()->user()->hasPermission('Journal Voucher Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->journalVoucherService->delete($journalVoucher);
        return redirect()->route('journal-vouchers.index')->with('success', 'Journal Voucher deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $journal_voucher_code = $this->journalVoucherService->createCode($companyId);
        return response()->json(['journal_voucher_code' => $journal_voucher_code]);
    }
}
