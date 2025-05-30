<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\SubChartOfAccount;
use App\Services\CategoryService;
use App\Services\ChartOfAccountService;
use App\Services\SubChartOfAccountService;
use App\Http\Requests\SubChartOfAccountRequest;
use App\Models\Company;

class SubChartOfAccountController extends Controller
{
    protected $subChartOfAccountService;
    protected $chartOfAccountService;
    protected $categoryService;

    public function __construct(SubChartOfAccountService $subChartOfAccountService, ChartOfAccountService $chartOfAccountService, CategoryService $categoryService)
    {
        $this->chartOfAccountService = $chartOfAccountService;
        $this->subChartOfAccountService = $subChartOfAccountService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Chart Of Accounts List')) {
            abort(403, 'Unauthorized action.');
        }
        $subChartOfAccounts = $this->subChartOfAccountService->getAll();
        return view('admin.sub_chart_of_accounts.index', compact('subChartOfAccounts'));
    }

    public function show($id)
    {
        if (!auth()->user()->hasPermission('Chart Of Accounts View')) {
            abort(403, 'Unauthorized action.');
        }
        $subChartOfAccount = $this->subChartOfAccountService->getById($id);
        return view('admin.sub_chart_of_accounts.show', compact('subChartOfAccount'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Chart Of Accounts Create')) {
            abort(403, 'Unauthorized action.');
        }
        $chartOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        $categories = $this->categoryService->getAllCategories();
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.sub_chart_of_accounts.create', compact('companies', 'chartOfAccounts', 'categories'));
    }

    public function store(SubChartOfAccountRequest $request)
    {
        if (!auth()->user()->hasPermission('Chart Of Accounts Create')) {
            abort(403, 'Unauthorized action.');
        }
        $this->subChartOfAccountService->create($request->validated());
        return redirect()->route('sub_chart_of_accounts.index')->with('success', 'Sub Chart of Account created successfully!');
    }

    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Chart Of Accounts Update')) {
            abort(403, 'Unauthorized action.');
        }
        $chartOfAccounts = $this->chartOfAccountService->getAllChartOfAccounts();
        $subChartOfAccount = SubChartOfAccount::findOrFail($id);
        $categories = $this->categoryService->getAllCategories();
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.sub_chart_of_accounts.edit', compact('subChartOfAccount', 'companies', 'chartOfAccounts', 'categories'));
    }

    public function update(SubChartOfAccountRequest $request, $id)
    {
        if (!auth()->user()->hasPermission('Chart Of Accounts Update')) {
            abort(403, 'Unauthorized action.');
        }
        $subChartOfAccount = SubChartOfAccount::findOrFail($id);
        $this->subChartOfAccountService->update($subChartOfAccount, $request->validated());
        return redirect()->route('sub_chart_of_accounts.index')->with('success', 'Sub Chart of Account updated successfully!');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasPermission('Chart Of Accounts Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $subChartOfAccount = SubChartOfAccount::findOrFail($id);
        $this->subChartOfAccountService->delete($subChartOfAccount);
        return redirect()->route('sub_chart_of_accounts.index')->with('success', 'Sub Chart of Account deleted successfully!');
    }
}