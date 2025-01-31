<?php
// app/Http/Controllers/CompanyController.php
namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Support\Facades\Storage;
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
        if (!auth()->user()->hasPermission('Companies List')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = $this->companyService->getAllCompanies();
        return view('admin.companies.index', compact('companies'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('Companies View')) {
            abort(403, 'Unauthorized action.');
        }
        $company = $this->companyService->getCompanyById($id);
        return view('admin.companies.view', compact('company'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Companies Create')) {
            abort(403, 'Unauthorized action.');
        }
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        return view('admin.companies.create', compact('countries', 'cities'));
    }

    public function store(StoreCompanyRequest $request)
    {
        if (!auth()->user()->hasPermission('Companies Create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'country_id' => $request->country,
            'city_id' => $request->city,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'ntn' => $request->ntn,
            'strn' => $request->strn,
            'is_active' => $request->is_active,
        ];
        if ($request->hasFile('logo')) {
            $uploadedFile = $request->file('logo');
            $filename = 'company_' . time() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->move('images/company', $filename);
            $data['logo_path'] = $filename;
        }
        $this->companyService->createCompany($data);
        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Companies Update')) {
            abort(403, 'Unauthorized action.');
        }
        $company = Company::findOrFail($id);
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        return view('admin.companies.edit', compact('company', 'countries', 'cities'));
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        if (!auth()->user()->hasPermission('Companies Update')) {
            abort(403, 'Unauthorized action.');
        }
        
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'country_id' => $request->country,
            'city_id' => $request->city,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'ntn' => $request->ntn,
            'strn' => $request->strn,
            'is_active' => $request->is_active,
        ];
        if ($request->hasFile('logo')) {
            $uploadedFile = $request->file('logo');
            $filename = 'company_' . time() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->move('images/company', $filename);
            $data['logo_path'] = $filename;
        }
        $this->companyService->updateCompany($company, $data);
        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        if (!auth()->user()->hasPermission('Companies Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $this->companyService->deleteCompany($company);
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
