<?php
// app/Services/CompanyService.php
namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Facades\File;

class CompanyService
{
    public function getAllCompanies()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $company = Company::orderBy('name', 'asc')->get();
        } else {
            $company = Company::where('id', auth()->user()->employee->company_id)->orderBy('name', 'asc')->get();
        }
        return $company;
    }

    public function createCompany(array $data)
    {
        return Company::create($data);
    }

    public function updateCompany(Company $company, array $data)
    {
        $company->update($data);
        return $company;
    }

    public function deleteCompany(Company $company)
    {
        $filePath = public_path('images/company/' . $company['logo_path']);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        $company->delete();
    }

    public function getCompanyById($id)
    {
        return Company::findOrFail($id);
    }
}
