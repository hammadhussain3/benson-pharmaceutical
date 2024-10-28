<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Services\BranchService;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Country;
use App\Models\City;

class BranchController extends Controller
{
    protected $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    public function index()
    {
        $branches = $this->branchService->getAllBranches();
        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->get();
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();

        return view('admin.branches.create', compact('companies', 'countries', 'cities')); // Pass companies, countries, and cities to the view
    }

    public function store(BranchRequest $request)
    {
        $this->branchService->createBranch($request->validated());
        return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
    }

    public function edit(Branch $branch)
    {
        $companies = Company::orderBy('name', 'asc')->get();
        $countries = Country::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();

        return view('admin.branches.edit', compact('branch', 'companies', 'countries', 'cities')); // Pass branch, companies, countries, and cities to the view
    }

    public function update(BranchRequest $request, Branch $branch)
    {
        $this->branchService->updateBranch($branch, $request->validated());
        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        $this->branchService->deleteBranch($branch);
        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully.');
    }
}
