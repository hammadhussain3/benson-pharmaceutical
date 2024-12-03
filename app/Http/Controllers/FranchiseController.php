<?php

namespace App\Http\Controllers;

use App\Http\Requests\FranchiseRequest;
use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Country;
use App\Models\City;
use App\Models\Company;
use App\Models\PaymentType;
use App\Services\FranchiseService;
use App\Services\PaymentTypeService;

class FranchiseController extends Controller
{
    protected $franchiseService;
    protected $paymentTypeService;

    public function __construct(FranchiseService $franchiseService, PaymentTypeService $paymentTypeService)
    {
        $this->franchiseService = $franchiseService;
        $this->paymentTypeService = $paymentTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('Franchise List')) {
            abort(403, 'Unauthorized action.');
        }
        $franchises = $this->franchiseService->getAllFranchises();
        return view('admin.franchises.index', compact('franchises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('Franchise Create')) {
            abort(403, 'Unauthorized action.');
        }
        if (auth()->user()->hasRole('Superadmin')) {
            $newFranchiseCode = "FRA";
        } else {
            $newFranchiseCode = $this->franchiseService->createFranchiseCode(auth()->user()->employee->company_id);
        }
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        $companies = Company::orderBy('name', 'asc')->get();
        $paymentTypes = $this->paymentTypeService->getAllPaymentTypes();
        return view('admin.franchises.create', compact('countries', 'cities', 'companies', 'paymentTypes', 'newFranchiseCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FranchiseRequest $request)
    {
        if (!auth()->user()->hasPermission('Franchise Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->franchiseService->createFranchise($request->validated());
        return redirect()->route('franchises.index')->with('success', 'Franchise created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Party $franchise)
    {
        if (!auth()->user()->hasPermission('Franchise View')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.franchises.show', compact('franchise'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Party $franchise)
    {
        if (!auth()->user()->hasPermission('Franchise Update')) {
            abort(403, 'Unauthorized action.');
        }
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        $companies = Company::orderBy('name', 'asc')->get();
        $paymentTypes = $this->paymentTypeService->getAllPaymentTypes();
        return view('admin.franchises.edit', compact('franchise', 'countries', 'cities', 'companies', 'paymentTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FranchiseRequest $request, Party $franchise)
    {
        if (!auth()->user()->hasPermission('Franchise Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->franchiseService->updateFranchise($franchise, $request->validated());
        return redirect()->route('franchises.index')->with('success', 'Franchise updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Party $franchise)
    {
        if (!auth()->user()->hasPermission('Franchise Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->franchiseService->deleteFranchise($franchise);
        return redirect()->route('franchises.index')->with('success', 'Franchise deleted successfully.');
    }

    public function createCodeByCompany($companyId)
    {
        $franchise_code = $this->franchiseService->createFranchiseCode($companyId);
        return response()->json(['franchise_code' => $franchise_code]);
    }

    public function getFranchisersByCompany($companyId)
    {
        $franchisers = Party::where('company_id', $companyId)->where('is_distributor', '1')->orderBy('name', 'asc')->get();
        return response()->json(['franchisers' => $franchisers]);
    }
}
