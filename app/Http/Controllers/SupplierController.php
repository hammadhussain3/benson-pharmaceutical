<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Country;
use App\Models\City;
use App\Models\PaymentType;
use App\Services\SupplierService;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
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
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        $paymentTypes = PaymentType::orderBy('name', 'asc')->get();
        return view('admin.suppliers.create', compact('countries', 'cities', 'paymentTypes'));
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
    public function show(Supplier $supplier)
    {
        if (!auth()->user()->hasPermission('Supplier View')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        if (!auth()->user()->hasPermission('Supplier Update')) {
            abort(403, 'Unauthorized action.');
        }
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::where('country_id', $supplier->country_id)->orderBy('name', 'asc')->get();
        $paymentTypes = PaymentType::orderBy('name', 'asc')->get();
        return view('admin.suppliers.edit', compact('supplier', 'countries', 'cities', 'paymentTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, Supplier $supplier)
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
    public function destroy(Supplier $supplier)
    {
        if (!auth()->user()->hasPermission('Supplier Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->supplierService->deleteSupplier($supplier);
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
