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
        if (!auth()->user()->hasPermission('Chart Of Accounts List')) {
            abort(403, 'Unauthorized action.');
        }
        $chartOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts(); // Fetch all chart of accounts
        return view('admin.chart_of_accounts.index', compact('chartOfAccounts')); // Return the index view
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('Chart Of Accounts View')) {
            abort(403, 'Unauthorized action.');
        }
        $chartOfAccount = $this->chartOfAccountService->getChartOfAccountById($id);
        return view('admin.chart_of_accounts.view', compact('chartOfAccount'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Chart Of Accounts Create')) {
            abort(403, 'Unauthorized action.');
        }
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.chart_of_accounts.create', compact('companies'));
    }

    public function store(StoreChartOfAccountRequest $request)
    {
        if (!auth()->user()->hasPermission('Chart Of Accounts Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->chartOfAccountService->createChartOfAccount($request->validated());
        return redirect()->route('chart_of_accounts.index')->with('success', 'Chart of Account created successfully!');
    }

    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Chart Of Accounts Update')) {
            abort(403, 'Unauthorized action.');
        }
        $chartOfAccount = ChartOfAccount::findOrFail($id);
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.chart_of_accounts.edit', compact('chartOfAccount', 'companies'));
    }

    public function update(UpdateChartOfAccountRequest $request, $id)
    {
        if (!auth()->user()->hasPermission('Chart Of Accounts Update')) {
            abort(403, 'Unauthorized action.');
        }
        $chartOfAccount = ChartOfAccount::findOrFail($id);
        $this->chartOfAccountService->updateChartOfAccount($chartOfAccount, $request->validated());
        return redirect()->route('chart_of_accounts.index')->with('success', 'Chart of Account updated successfully!');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasPermission('Chart Of Accounts Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $chartOfAccount = ChartOfAccount::findOrFail($id);
        $this->chartOfAccountService->deleteChartOfAccount($chartOfAccount);
        return redirect()->route('chart_of_accounts.index')->with('success', 'Chart of Account deleted successfully!');
    }
}
