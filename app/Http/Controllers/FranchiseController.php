<?php

namespace App\Http\Controllers;

use App\Http\Requests\FranchiseRequest;
use Illuminate\Http\Request;
use App\Models\Franchise;
use App\Models\Country;
use App\Models\City;
use App\Models\PaymentType;
use App\Services\FranchiseService;

class FranchiseController extends Controller
{
    protected $franchiseService;

    public function __construct(FranchiseService $franchiseService)
    {
        $this->franchiseService = $franchiseService;
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
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        $paymentTypes = PaymentType::orderBy('name', 'asc')->get();
        return view('admin.franchises.create', compact('countries', 'cities', 'paymentTypes'));
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
    public function show(Franchise $franchise)
    {
        if (!auth()->user()->hasPermission('Franchise View')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.franchises.show', compact('franchise'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Franchise $franchise)
    {
        if (!auth()->user()->hasPermission('Franchise Update')) {
            abort(403, 'Unauthorized action.');
        }
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::where('country_id', $franchise->country_id)->orderBy('name', 'asc')->get();
        $paymentTypes = PaymentType::orderBy('name', 'asc')->get();
        return view('admin.franchises.edit', compact('franchise', 'countries', 'cities', 'paymentTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FranchiseRequest $request, Franchise $franchise)
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
    public function destroy(Franchise $franchise)
    {
        if (!auth()->user()->hasPermission('Franchise Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->franchiseService->deleteFranchise($franchise);
        return redirect()->route('franchises.index')->with('success', 'Franchise deleted successfully.');
    }
}
