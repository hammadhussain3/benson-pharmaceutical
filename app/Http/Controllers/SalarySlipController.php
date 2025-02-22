<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalarySlipRequest;
use App\Models\SalaryAllowances;
use Illuminate\Support\Facades\DB;
use App\Models\SalarySlip;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Services\SalarySlipService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use App\Models\Loan;
use Carbon\Carbon;

class SalarySlipController extends Controller
{
    protected $salarySlipService;
    protected $employeeService;

    public function __construct(SalarySlipService $salarySlipService, EmployeeService $employeeService)
    {
        $this->salarySlipService = $salarySlipService;
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        if (!auth()->user()->hasPermission('Salaries List')) {
            abort(403, 'Unauthorized action.');
        }
        $salarySlipsQuery = SalarySlip::with(['employee', 'company'])
            ->orderBy(Employee::select(DB::raw("CONCAT(first_name, ' ', last_name)"))
                ->whereColumn('employees.id', 'salary_slips.employee_id')
            );

        if (!auth()->user()->hasRole('Superadmin')) {
            $salarySlipsQuery->where('company_id', auth()->user()->employee->company_id);
        }
    
        $salarySlips = $salarySlipsQuery->get();
        
        return view('admin.salary_slips.index', compact('salarySlips'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('Salaries Create')) {
            abort(403, 'Unauthorized action.');
        }
        $employees = $this->employeeService->getAllEmployees();
        $companies = Company::all();
        $branches = Branch::all();
        $departments = Department::all();
        $designations = Designation::all();

        return view('admin.salary_slips.create', compact('employees', 'companies', 'branches', 'departments', 'designations'));
    }

    public function store(SalarySlipRequest $request)
    {
        if (!auth()->user()->hasPermission('Salaries Create')) {
            abort(403, 'Unauthorized action.');
        }

        $salarySlip = SalarySlip::where('employee_id', $request->employee)->where('month', $request['month'])->where('year', $request['year'])->first();

        if ($salarySlip) {
            return back()->with('error', 'salary slip already created for the selected employee and month.');
        }
        
        $this->salarySlipService->createSalarySlip($request->validated());

        $month = \DateTime::createFromFormat('Y-m', "{$request->year}-{$request->month}");

        return redirect()->route('salary.sheet.show', [
            'employee_id' => $request->employee,
            'month' => $month->format('Y-m')
        ])->with('success', 'Salary Slip created successfully.');
    }

    public function edit($id)
    {
        if (!auth()->user()->hasPermission('Salaries Update')) {
            abort(403, 'Unauthorized action.');
        }
        $salarySlip = SalarySlip::findOrFail($id);

        $currentEmployee = Employee::findOrFail($salarySlip->employee_id);
        $employees = $this->employeeService->getAllEmployees();
        $companies = Company::all();
        $branches = Branch::all();
        $departments = Department::all();
        $designations = Designation::all();
        $singleBranch = Branch::where('id', $currentEmployee->branch_id)->first();
        $singleDepartment = Department::where('id', $currentEmployee->department_id)->first();
        $singleDesignation = Designation::where('id', $currentEmployee->designation_id)->first();
        $salaryDeductions = SalaryAllowances::where('employee_id', $currentEmployee->id)->where('salary_slip_id', $id)->where('type', 'deduction')->get();
        $salaryAllowances = SalaryAllowances::where('employee_id', $currentEmployee->id)->where('salary_slip_id', $id)->where('type', 'allowance')->get();

        return view('admin.salary_slips.edit', compact('salarySlip', 'currentEmployee', 'employees', 'companies', 'branches', 'departments', 'designations', 'singleBranch', 'singleDepartment', 'singleDesignation', 'salaryAllowances', 'salaryDeductions'));
    }

    public function update(SalarySlipRequest $request, $id)
    {
        if (!auth()->user()->hasPermission('Salaries Update')) {
            abort(403, 'Unauthorized action.');
        }
        $salarySlip = SalarySlip::find($id);

        $this->salarySlipService->updateSalarySlip($salarySlip, $request->validated());

        $month = \DateTime::createFromFormat('Y-m', "{$request->year}-{$request->month}");

        return redirect()->route('salary.sheet.show', parameters: [
            'employee_id' => $request->employee,
            'month' => $month->format('Y-m')
        ])->with('success', 'Salary Slip updated successfully.');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasPermission('Salaries Delete')) {
            abort(403, 'Unauthorized action.');
        }
        $salarySlip = SalarySlip::findOrFail($id);
    
        if ($salarySlip->loan_advance > 0) {
            $latestLoan = Loan::where('employee_id', $salarySlip->employee_id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($latestLoan) {
                $newRemaining = $latestLoan->remaining + $salarySlip->loan_advance;

                if ($newRemaining > $latestLoan->amount) {
                    $excessAmount = $newRemaining - $latestLoan->amount;
                    $latestLoan->update(['remaining' => $latestLoan->amount]);
                    $secondLatestLoan = Loan::where('employee_id', $salarySlip->employee_id)
                        ->where('id', '!=', $latestLoan->id)
                        ->orderBy('created_at', 'desc')
                        ->first();

                    if ($secondLatestLoan) {
                        $newSecondRemaining = $secondLatestLoan->remaining + $excessAmount;
                        $secondLatestLoan->update(['remaining' => $newSecondRemaining]);
                    }
                } else {
                    $latestLoan->update(['remaining' => $newRemaining]);
                }
            }
        }
        $salarySlip->delete();
        return redirect()->route('salary_slips.index')->with('success', 'Salary Slip deleted successfully.');
    }
}
