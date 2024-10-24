<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Services\CountryService;
use App\Models\Country;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index()
    {
        $countries = $this->countryService->getAllCountries();
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(CountryRequest $request)
    {
        $this->countryService->createCountry($request->validated());
        return redirect()->route('countries.index')->with('success', 'Country created successfully.');
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(CountryRequest $request, Country $country)
    {
        $this->countryService->updateCountry($country, $request->validated());
        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)
    {
        $this->countryService->deleteCountry($country);
        return redirect()->route('countries.index')->with('success', 'Country deleted successfully.');
    }
}
