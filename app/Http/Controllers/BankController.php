<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;
use App\Models\Bank;
use App\Models\Country; // Import the Country model
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
        $banks = $this->bankService->getAllBanks();
        return view('admin.banks.index', compact('banks'));
    }

    public function create()
    {
        $countries = Country::orderBy('name', 'asc')->get(); // Fetch all countries for the dropdown
        return view('admin.banks.create', compact('countries'));
    }

    public function store(StoreBankRequest $request)
    {
        $this->bankService->createBank($request->validated());
        return redirect()->route('banks.index')->with('success', 'Bank created successfully.');
    }

    public function edit($id)
    {
        $bank = Bank::findOrFail($id); // Use findOrFail to fetch the bank
        $countries = Country::orderBy('name', 'asc')->get(); // Fetch all countries for the dropdown
        return view('admin.banks.edit', compact('bank', 'countries'));
    }

    public function update(UpdateBankRequest $request, $id)
    {
        $bank = Bank::findOrFail($id); // Use findOrFail to fetch the bank
        $this->bankService->updateBank($bank, $request->validated());
        return redirect()->route('banks.index')->with('success', 'Bank updated successfully.');
    }

    public function destroy(Bank $bank)
    {
        $this->bankService->deleteBank($bank);
        return redirect()->route('banks.index')->with('success', 'Bank deleted successfully.');
    }
}
