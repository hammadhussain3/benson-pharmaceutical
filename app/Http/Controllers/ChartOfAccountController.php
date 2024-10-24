<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Services\ChartOfAccountService;
use App\Http\Requests\StoreChartOfAccountRequest;
use App\Http\Requests\UpdateChartOfAccountRequest;
use App\Models\Company;

class ChartOfAccountController extends Controller
{
    protected $chartOfAccountService;

    public function __construct(ChartOfAccountService $chartOfAccountService)
    {
        $this->chartOfAccountService = $chartOfAccountService;
    }

    public function index()
    {
        $chartOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts(); // Fetch all chart of accounts
        return view('admin.chart_of_accounts.index', compact('chartOfAccounts')); // Return the index view
    }

    public function create()
    {
        $companies = Company::all();
        return view('admin.chart_of_accounts.create', compact('companies'));
    }

    public function store(StoreChartOfAccountRequest $request)
    {
        $this->chartOfAccountService->createChartOfAccount($request->validated());
        return redirect()->route('chart_of_accounts.index')->with('success', 'Chart of Account created successfully!');
    }

    public function edit($id)
    {
        $chartOfAccount = ChartOfAccount::findOrFail($id);
        $companies = Company::all();
        return view('admin.chart_of_accounts.edit', compact('chartOfAccount', 'companies'));
    }

    public function update(UpdateChartOfAccountRequest $request, $id)
    {
        $chartOfAccount = ChartOfAccount::findOrFail($id);
        $this->chartOfAccountService->updateChartOfAccount($chartOfAccount, $request->validated());
        return redirect()->route('chart_of_accounts.index')->with('success', 'Chart of Account updated successfully!');
    }

    public function destroy($id)
    {
        $chartOfAccount = ChartOfAccount::findOrFail($id);
        $this->chartOfAccountService->deleteChartOfAccount($chartOfAccount);
        return redirect()->route('chart_of_accounts.index')->with('success', 'Chart of Account deleted successfully!');
    }
}
