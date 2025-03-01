<?php

namespace App\Http\Controllers;

use App\Models\SalaryAllowances;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\Salary;
use App\Models\SalarySlip;
use App\Models\Company;
use App\Models\SalaryTaxSlab;
use App\Models\LeaveType;
use Carbon\Carbon;
use NumberFormatter;

class SalarySheetController extends Controller
{
    // Show the form to select an employee and month
    public function index()
    {
        $employees = Employee::all(); // Get all employees for dropdown
        return view('admin.salary_sheet.index', compact('employees'));
    }

    // Process the form and display the salary sheet
    public function showSalarySheet(Request $request)
    {
        if (!auth()->user()->hasPermission('Salaries View')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|date_format:Y-m',
        ]);

        $employee = Employee::find($request->employee_id);
        $date = \DateTime::createFromFormat('Y-m', $request->month);

        $month = $date->format('m');
        $year = $date->format('Y');

        // $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        // $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
        $formattedMonth = Carbon::createFromFormat('Y-m', $request->month)->format('M Y');
        $salarySlip = SalarySlip::where('employee_id', $employee->id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        $salaryAllowances = SalaryAllowances::where('employee_id', $request->employee_id)->where('salary_slip_id', $salarySlip->id)->get();

        if (!$salarySlip) {
            return back()->with('error', 'No salary slip found for the selected employee and month.');
        }

        // Calculate the number of days in the given month and year
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $salaryPerDay = $employee->net_salary / $daysInMonth;
        $salaryPerHour = $salaryPerDay / 8;
        $leaveIds = collect($salarySlip->leaves)->pluck('id');
        $leaveTypes = LeaveType::whereIn('id', $leaveIds)->get()->keyBy('id');
        $leaves = [];
        $leavesTotalAmount = 0;
        foreach ($salarySlip->leaves as $leave) {
            if ($leaveType = $leaveTypes->get($leave['id'])) {
                $leavePerDayDeduction = ($leaveType->deduction / 100) * $salaryPerDay;
                $leaves[] = [
                    'name' => $leaveType->name,
                    'days' => $leave['days'],
                    'per_day_deduction' => $leavePerDayDeduction,
                    'total_deduction' => $leavePerDayDeduction * $leave['days'],
                ];
                $leavesTotalAmount += $leavePerDayDeduction * $leave['days'];
            }
        }
        $lateDeduction = $salaryPerHour * $salarySlip->late_in_early_out_deduction;
        $overtimePay = $salarySlip->overtime > 0 
            ? ($salaryPerHour * $salarySlip->overtime + (0.25 * $salaryPerHour)) 
            : 0;
        $loan = Loan::where('employee_id', $employee->id)
            ->where('company_id', $employee->company_id)
            ->first();
        $loanDeduction = $loan ? $loan->amount : 0;
        $taxSlab = SalaryTaxSlab::where('company_id', $employee->company_id)
            ->where('slab_start', '<=', $employee->net_salary)
            ->where('slab_end', '>=', $employee->net_salary)
            ->first();
        $incomeTax = $taxSlab ? $salarySlip->income_tax : 0;
        $totalDeductions = $leavesTotalAmount + $lateDeduction + $loanDeduction + $incomeTax;
        $netSalary = $employee->net_salary;
        $salaryDeductionAmount = $salaryAllowances->where('type', 'deduction')->sum('amount');
        $salaryAllowanceAmount = $salaryAllowances->where('type', 'allowance')->sum('amount');
        $totalDebit = $leavesTotalAmount + $lateDeduction + $salarySlip->loan_advance + $incomeTax + $salaryDeductionAmount + $salarySlip->eob;
        $totalCredit = $netSalary + $overtimePay + $salarySlip->arrears + $salaryAllowanceAmount;
        $totalSalary = $totalCredit - $totalDebit;
        $totalSalaryRounded = round($totalSalary, 2);
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $integerPart = floor($totalSalaryRounded);
        $totalSalaryInWords = $formatter->format($integerPart);
        $company = Company::where('id',$employee->company_id)->first();

        return view('admin.salary_sheet.show', compact(
            'employee',
            'salarySlip',
            'formattedMonth',
            'totalSalaryRounded',
            'totalDebit',
            'totalCredit',
            'totalSalary',
            'salaryPerDay',
            'netSalary',
            'leaves',
            'lateDeduction',
            'overtimePay',
            'loanDeduction',
            'incomeTax',
            'totalSalaryInWords',
            'daysInMonth',
            'company',
            'salaryAllowances'
        ));
    }
}
