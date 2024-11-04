<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Loan;
use App\Services\LoanService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanController extends Controller
{
    protected $loanService;
    protected $employeeService;

    public function __construct(LoanService $loanService, EmployeeService $employeeService)
    {
        $this->loanService = $loanService;
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Loan List')) {
            abort(403, 'Unauthorized action.');
        }
        $loansQuery = Loan::with(['employee', 'company'])
            ->orderBy(Employee::select(DB::raw("CONCAT(first_name, ' ', last_name)"))
                ->whereColumn('employees.id', 'loans.employee_id')
            );

        if (!auth()->user()->hasRole('Superadmin')) {
            $companyId = auth()->user()->employee->company_id;
            $loansQuery->whereHas('employee', function($query) use ($companyId) {
                $query->where('company_id', $companyId);
            });
        }
    
        $loans = $loansQuery->get();

        return view('admin.loans.index', compact('loans'));
    }

    public function view($id)
    {
        if (!auth()->user()->hasPermission('Loan View')) {
            abort(403, 'Unauthorized action.');
        }
        $loan = Loan::findOrFail($id);
        return view('admin.loans.view', compact('loan'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Loan Create')) {
            abort(403, 'Unauthorized action.');
        }
        $employees = $this->employeeService->getAllEmployees();
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.loans.create', compact('employees', 'companies'));
    }

    public function store(LoanRequest $request)
    {
        if (!auth()->user()->hasPermission('Loan Create')) {
            abort(403, 'Unauthorized action.');
        }
        $loan = Loan::where('employee_id', $request->employee)->where('remaining', '>=', '1')->first();
        if($loan){
            return back()->with('error', 'Loan found for the selected employee.');
        }
        $this->loanService->createLoan($request->validated());
        return redirect()->route('loans.index')->with('success', 'Loan created successfully.');
    }

    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Loan Update')) {
            abort(403, 'Unauthorized action.');
        }
        $loan = Loan::findOrFail($id);
        $employees = $this->employeeService->getAllEmployees();
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.loans.edit', compact('loan', 'employees', 'companies'));
    }

    public function update(LoanRequest $request, $id)
    {
        if (!auth()->user()->hasPermission('Loan Update')) {
            abort(403, 'Unauthorized action.');
        }
        $loan = Loan::findOrFail($id);
        $this->loanService->updateLoan($loan, $request->validated());
        return redirect()->route('loans.index')->with('success', 'Loan updated successfully.');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasPermission('Loan Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $loan = Loan::findOrFail($id);
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully.');
    }
    public function getLoansByEmployee($employeeId, Request $request)
    {
        if (!auth()->user()->hasPermission('Loan List')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }
        $totalMonthlyPayment = 0;
        $currentMonth = $request->has('month') ? Carbon::createFromFormat('Y-m', $request->input('month')) : Carbon::now();

        $loans = Loan::where('employee_id', $employeeId)
            ->where('remaining', '>=', 0)
            ->whereMonth('created_at', '<=', $currentMonth->month)
            ->whereYear('created_at', '<=', $currentMonth->year)
            ->sum('amount');

        if ($loans > 0) {
            $payback_months = Loan::where('employee_id', $employeeId)
                ->orderBy('created_at', 'desc')
                ->value('payback_months');

            if ($payback_months > 0) {
                $totalMonthlyPayment = $loans / $payback_months;
            }
        }
        
        // $previousMonth = $request->has('month') ? Carbon::createFromFormat('Y-m', $request->input('month')) : Carbon::now()->subMonth();

        // $loans = Loan::where('employee_id', $employeeId)
        //     ->where('remaining', '>=', 0)
        //     ->whereMonth('created_at', '<=', $previousMonth->month)
        //     ->whereYear('created_at', '<=', $previousMonth->year)
        //     ->get();

        // foreach ($loans as $loan) {
        //     $loanStartMonth = Carbon::parse($loan->created_at);
        //     $monthsElapsed = $loanStartMonth->diffInMonths($previousMonth);

        //     if ($monthsElapsed <= $loan->payback_months) {
        //         $installment = $loan->amount / $loan->payback_months;
        //         $totalMonthlyPayment += min($installment, $loan->remaining);
        //     }
        // }

        return response()->json(['loan' => $totalMonthlyPayment]);
    }
}
