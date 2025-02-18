<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Country;
use App\Services\BankService;
use Illuminate\Http\Request;

class BankController extends Controller
{
    protected $bankService;

    public function __construct(BankService $bankService)
    {
        $this->bankService = $bankService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Bank List')) {
            abort(403, 'Unauthorized action.');
        }

        $banks = $this->bankService->getAllBanks();
        return view('admin.banks.index', compact('banks'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('Bank View')) {
            abort(403, 'Unauthorized action.');
        }

        $bank = $this->bankService->getBankById($id);
        return view('admin.banks.view', compact('bank'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Bank Create')) {
            abort(403, 'Unauthorized action.');
        }

        $countries = Country::orderBy('name', 'asc')->get(); // Fetch all countries for the dropdown
        return view('admin.banks.create', compact('countries'));
    }

    public function store(StoreBankRequest $request)
    {
        if (!auth()->user()->hasPermission('Bank Create')) {
            abort(403, 'Unauthorized action.');
        }
    
        try {
            $this->bankService->createBank($request->validated());
            return redirect()->route('banks.index')->with('success', 'Bank created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Bank Update')) {
            abort(403, 'Unauthorized action.');
        }

        $bank = Bank::findOrFail($id); // Use findOrFail to fetch the bank
        $countries = Country::orderBy('name', 'asc')->get(); // Fetch all countries for the dropdown
        return view('admin.banks.edit', compact('bank', 'countries'));
    }

    public function update(UpdateBankRequest $request, Bank $bank)
    {
        if (!auth()->user()->hasPermission('Bank Update')) {
            abort(403, 'Unauthorized action.');
        }

        $this->bankService->updateBank($bank, $request->validated());
        return redirect()->route('banks.index')->with('success', 'Bank updated successfully.');
    }

    public function destroy(Bank $bank)
    {
        if (!auth()->user()->hasPermission('Bank Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $this->bankService->deleteBank($bank);
        return redirect()->route('banks.index')->with('success', 'Bank deleted successfully.');
    }

    public function getBanksByBranch($branchId)
    {
        $branch = Branch::findOrFail($branchId);
        $banks = Bank::where('country_id', $branch->country_id)->get();
        return response()->json(['banks' => $banks]);
    }
}
