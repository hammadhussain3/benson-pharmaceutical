<?php

namespace App\Http\Controllers;

use App\Models\ReceiptVoucher;
use App\Http\Requests\ReceiptVoucherRequest;
use App\Services\ReceiptVoucherService;
use App\Services\ChartOfAccountService;
use App\Services\CompanyService;
use App\Services\FranchiseService;

class ReceiptVoucherController extends Controller
{
    protected $receiptVoucherService;
    protected $chartOfAccountService;
    protected $franchiseService;
    protected $companyService;

    public function __construct(ReceiptVoucherService $receiptVoucherService, ChartOfAccountService $chartOfAccountService, CompanyService $companyService, FranchiseService $franchiseService)
    {
        $this->receiptVoucherService = $receiptVoucherService;
        $this->chartOfAccountService = $chartOfAccountService;
        $this->franchiseService = $franchiseService;
        $this->companyService = $companyService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Receipt Voucher List')) {
            abort(403, 'Unauthorized action.');
        }
        $receiptVouchers = $this->receiptVoucherService->getAll();
        return view('admin.receipt-vouchers.index', compact('receiptVouchers'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Receipt Voucher Create')) {
            abort(403, 'Unauthorized action.');
        }
        if (auth()->user()->hasRole('Superadmin')) {
            $newReceiptVoucherCode = "RV";
        } else {
            $newReceiptVoucherCode = $this->receiptVoucherService->createCode(auth()->user()->employee->company_id);
        }
        $companies = $this->companyService->getAllCompanies();
        $charOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        $franchisers = $this->franchiseService->getAllFranchises();
        return view('admin.receipt-vouchers.create', compact('companies', 'charOfAccounts', 'franchisers', 'newReceiptVoucherCode'));
    }

    public function store(ReceiptVoucherRequest $request)
    {
        if (!auth()->user()->hasPermission('Receipt Voucher Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->receiptVoucherService->create($request->validated());
        return redirect()->route('receipt-vouchers.index')->with('success', 'Receipt Voucher created successfully.');
    }

    public function show($id)
    {
        if (!auth()->user()->hasPermission('Receipt Voucher View')) {
            abort(403, 'Unauthorized action.');
        }
        $receiptVoucher = $this->receiptVoucherService->getById($id);
        return view('admin.receipt-vouchers.show', compact('receiptVoucher'));
    }

    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Receipt Voucher Update')) {
            abort(403, 'Unauthorized action.');
        }
        $receiptVoucher = $this->receiptVoucherService->getById($id);
        $companies = $this->companyService->getAllCompanies();
        $charOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        $franchisers = $this->franchiseService->getAllFranchises();
        return view('admin.receipt-vouchers.edit', compact('receiptVoucher', 'companies', 'charOfAccounts', 'franchisers'));
    }

    public function update(ReceiptVoucherRequest $request, ReceiptVoucher $receiptVoucher)
    {
        if (!auth()->user()->hasPermission('Receipt Voucher Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->receiptVoucherService->update($receiptVoucher, $request->validated());
        return redirect()->route('receipt-vouchers.index')->with('success', 'Receipt Voucher updated successfully');
    }

    public function destroy(ReceiptVoucher $receiptVoucher)
    {
        if (!auth()->user()->hasPermission('Receipt Voucher Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->receiptVoucherService->delete($receiptVoucher);
        return redirect()->route('receipt-vouchers.index')->with('success', 'Receipt Voucher deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $receipt_voucher_code = $this->receiptVoucherService->createCode($companyId);
        return response()->json(['receipt_voucher_code' => $receipt_voucher_code]);
    }
}
