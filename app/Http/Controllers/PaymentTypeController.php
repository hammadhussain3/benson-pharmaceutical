<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use App\Services\PaymentTypeService;
use App\Http\Requests\StorePaymentTypeRequest;
use App\Http\Requests\UpdatePaymentTypeRequest;
use App\Models\Company;

class PaymentTypeController extends Controller
{
    protected $paymentTypeService;

    public function __construct(PaymentTypeService $paymentTypeService)
    {
        $this->paymentTypeService = $paymentTypeService;
    }

    public function index()
    {
        $paymentTypes = $this->paymentTypeService->getAllPaymentTypes(); // Fetch all payment types
        return view('admin.payment_types.index', compact('paymentTypes')); // Return the index view
    }

    public function view($id)
    {
        $paymentType = $this->paymentTypeService->getPaymentTypeById($id);
        return view('admin.payment_types.view', compact('paymentType'));
    }

    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.payment_types.create', compact('companies'));
    }

    public function store(StorePaymentTypeRequest $request)
    {
        $this->paymentTypeService->createPaymentType($request->validated());
        return redirect()->route('payment_types.index')->with('success', 'Payment Type created successfully!');
    }

    public function edit($id)
    {
        $paymentType = PaymentType::findOrFail($id);
        $companies = Company::orderBy('name', 'asc')->get();

        return view('admin.payment_types.edit', compact('paymentType', 'companies')); // Return the edit view
    }

    public function update(UpdatePaymentTypeRequest $request, $id)
    {
        $paymentType = PaymentType::findOrFail($id);
        $this->paymentTypeService->updatePaymentType($paymentType, $request->validated());
        return redirect()->route('payment_types.index')->with('success', 'Payment Type updated successfully!');
    }

    public function destroy($id)
    {
        $paymentType = PaymentType::findOrFail($id);
        $this->paymentTypeService->deletePaymentType($paymentType);
        return redirect()->route('payment_types.index')->with('success', 'Payment Type deleted successfully!');
    }
}
