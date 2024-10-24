<?php
// app/Http/Controllers/CompanyController.php
namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Country; // Assuming you have a Country model
use App\Models\City; // Assuming you have a City model
use App\Services\CompanyService;

class CompanyController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index()
    {
        $companies = $this->companyService->getAllCompanies();
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        $countries = Country::all();
        $cities = City::all();
        return view('admin.companies.create', compact('countries', 'cities'));
    }

    public function store(StoreCompanyRequest $request)
    {
        $this->companyService->createCompany($request->validated());
        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $countries = Country::all();
        $cities = City::all();
        return view('admin.companies.edit', compact('company', 'countries', 'cities'));
    }

    public function update(UpdateCompanyRequest $request, $id)
    {
        $company = Company::findOrFail($id);
        $this->companyService->updateCompany($company, $request->validated());
        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $this->companyService->deleteCompany($company);
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
