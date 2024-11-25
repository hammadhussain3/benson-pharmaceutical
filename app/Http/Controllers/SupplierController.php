<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Country;
use App\Models\City;
use App\Models\Company;
use App\Services\SupplierService;
use App\Services\PaymentTypeService;
use App\Services\InvoiceService;

class SupplierController extends Controller
{
    protected $supplierService;
    protected $paymentTypeService;
    protected $invoiceService;

    public function __construct(SupplierService $supplierService, PaymentTypeService $paymentTypeService, InvoiceService $invoiceService)
    {
        $this->supplierService = $supplierService;
        $this->paymentTypeService = $paymentTypeService;
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('Supplier List')) {
            abort(403, 'Unauthorized action.');
        }
        
        $suppliers = $this->supplierService->getAllSuppliers();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('Supplier Create')) {
            abort(403, 'Unauthorized action.');
        }
        if (auth()->user()->hasRole('Superadmin')) {
            $newSupplierCode = "SUP";
        } else {
            $newSupplierCode = $this->supplierService->createSupplierCode(auth()->user()->employee->company_id);
        }
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        $companies = Company::orderBy('name', 'asc')->get();
        $paymentTypes = $this->paymentTypeService->getAllPaymentTypes();
        return view('admin.suppliers.create', compact('countries', 'cities', 'companies', 'paymentTypes', 'newSupplierCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        if (!auth()->user()->hasPermission('Supplier Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->supplierService->createSupplier($request->validated());
        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Party $supplier)
    {
        if (!auth()->user()->hasPermission('Supplier View')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Party $supplier)
    {
        if (!auth()->user()->hasPermission('Supplier Update')) {
            abort(403, 'Unauthorized action.');
        }
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        $companies = Company::orderBy('name', 'asc')->get();
        $paymentTypes = $this->paymentTypeService->getAllPaymentTypes();
        return view('admin.suppliers.edit', compact('supplier', 'countries', 'cities', 'companies', 'paymentTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, Party $supplier)
    {
        if (!auth()->user()->hasPermission('Supplier Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->supplierService->updateSupplier($supplier, $request->validated());
        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Party $supplier)
    {
        if (!auth()->user()->hasPermission('Supplier Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->supplierService->deleteSupplier($supplier);
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }

    public function createCodeByCompany($companyId)
    {
        $supplier_code = $this->supplierService->createSupplierCode($companyId);
        return response()->json(['supplier_code' => $supplier_code]);
    }

    public function getSuppliersByCompany($companyId)
    {
        $suppliers = Party::where('company_id', $companyId)->where('is_supplier', '1')->orderBy('name', 'asc')->get();
        return response()->json(['suppliers' => $suppliers]);
    }

    public function getSupplierByInvoice($invoiceId)
    {
        $invoice = $this->invoiceService->getInvoiceById($invoiceId);
        $supplier = $this->supplierService->getSupplierById($invoice->party_id);
        return response()->json(['supplier' => $supplier]);
    }
}
