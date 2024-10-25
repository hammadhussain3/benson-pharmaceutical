<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Loan;
use App\Services\LoanService;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function index()
    {
        $loans = Loan::with(['employee', 'company'])->get();
        return view('admin.loans.index', compact('loans'));
    }

    public function create()
    {

        $employees = Employee::all();
        $companies = Company::all();
        return view('admin.loans.create', compact('employees', 'companies'));
    }

    public function store(LoanRequest $request)
    {
        $this->loanService->createLoan($request->validated());
        return redirect()->route('loans.index')->with('success', 'Loan created successfully.');
    }

    public function edit($id)
    {
        $loan = Loan::findOrFail($id);
        $employees = Employee::all();
        $companies = Company::all();
        return view('admin.loans.edit', compact('loan', 'employees', 'companies'));
    }

    public function getLoansByEmployee($employeeId)
    {
        // Fetch the loan record for the given employee ID
        $loan = Loan::where('employee_id', $employeeId)->first();

        $monthlyPayment = 0;

        if ($loan) {
            $monthlyPayment = $loan->remaining == 0 ? 0 : $loan->amount / $loan->payback_months;
        }

        return response()->json(['loan' => $monthlyPayment]);
    }

    public function update(LoanRequest $request, $id)
    {
        $loan = Loan::findOrFail($id);
        $this->loanService->updateLoan($loan, $request->validated());
        return redirect()->route('loans.index')->with('success', 'Loan updated successfully.');
    }

    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully.');
    }
}
