<?php

namespace App\Http\Controllers;

use App\Models\PaymentVoucher;
use App\Http\Requests\PaymentVoucherRequest;
use App\Services\PaymentVoucherService;
use App\Services\ChartOfAccountService;
use App\Services\CompanyService;
use App\Services\SupplierService;

class PaymentVoucherController extends Controller
{
    protected $paymentVoucherService;
    protected $chartOfAccountService;
    protected $companyService;
    protected $supplierService;

    public function __construct(PaymentVoucherService $paymentVoucherService, ChartOfAccountService $chartOfAccountService, CompanyService $companyService, SupplierService $supplierService)
    {
        $this->paymentVoucherService = $paymentVoucherService;
        $this->chartOfAccountService = $chartOfAccountService;
        $this->companyService = $companyService;
        $this->supplierService = $supplierService;
    }

    public function index()
    {
        $paymentVouchers = $this->paymentVoucherService->getAll();
        return view('admin.payment-vouchers.index', compact('paymentVouchers'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $newPaymentVoucherCode = "PVR";
        } else {
            $newPaymentVoucherCode = $this->paymentVoucherService->createCode(auth()->user()->employee->company_id);
        }
        $companies = $this->companyService->getAllCompanies();
        $charOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        $suppliers = $this->supplierService->getAllSuppliers();
        return view('admin.payment-vouchers.create', compact('companies', 'charOfAccounts', 'suppliers', 'newPaymentVoucherCode'));
    }

    public function store(PaymentVoucherRequest $request)
    {
        $this->paymentVoucherService->create($request->validated());
        return redirect()->route('payment-vouchers.index')->with('success', 'Payment Voucher created successfully.');
    }

    public function show($id)
    {
        $paymentVoucher = $this->paymentVoucherService->getById($id);
        return view('admin.payment-vouchers.show', compact('paymentVoucher'));
    }

    public function edit($id)
    {
        $paymentVoucher = $this->paymentVoucherService->getById($id);
        $companies = $this->companyService->getAllCompanies();
        $charOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        $suppliers = $this->supplierService->getAllSuppliers();
        return view('admin.payment-vouchers.edit', compact('paymentVoucher', 'companies', 'charOfAccounts', 'suppliers'));
    }

    public function update(PaymentVoucherRequest $request, PaymentVoucher $paymentVoucher)
    {
        $this->paymentVoucherService->update($paymentVoucher, $request->validated());
        $paymentVoucher->update($request->validated());
        return redirect()->route('payment-vouchers.index')->with('success', 'Payment Voucher updated successfully');
    }

    public function destroy(PaymentVoucher $paymentVoucher)
    {
        $this->paymentVoucherService->delete($paymentVoucher);
        return redirect()->route('payment-vouchers.index')->with('success', 'Payment Voucher deleted successfully');
    }

    public function createCodeByCompany($companyId)
    {
        $payment_voucher_code = $this->paymentVoucherService->createCode($companyId);
        return response()->json(['payment_voucher_code' => $payment_voucher_code]);
    }
}
