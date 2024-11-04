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
        if (!auth()->user()->hasPermission('Countries List')) {
            abort(403, 'Unauthorized action.');
        }
        $countries = $this->countryService->getAllCountries();
        return view('admin.countries.index', compact('countries'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('Countries View')) {
            abort(403, 'Unauthorized action.');
        }
        $country =  $this->countryService->getCountryById($id);
        return view('admin.countries.view', compact('country'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Countries Create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.countries.create');
    }

    public function store(CountryRequest $request)
    {
        if (!auth()->user()->hasPermission('Countries Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->countryService->createCountry($request->validated());
        return redirect()->route('countries.index')->with('success', 'Country created successfully.');
    }

    public function edit(Country $country)
    {
        if (!auth()->user()->hasPermission('Countries Update')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.countries.edit', compact('country'));
    }

    public function update(CountryRequest $request, Country $country)
    {
        if (!auth()->user()->hasPermission('Countries Update')) {
            abort(403, 'Unauthorized action.');
        }
        $this->countryService->updateCountry($country, $request->validated());
        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)
    {
        if (!auth()->user()->hasPermission('Countries List')) {
            abort(403, 'Unauthorized action.');
        }
        $this->countryService->deleteCountry($country);
        return redirect()->route('countries.index')->with('success', 'Country deleted successfully.');
    }
}
