<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\Salary;
use App\Models\SalarySlip;
use App\Models\SalaryTaxSlab;
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
        $formattedMonth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
        $salarySlip = SalarySlip::where('employee_id', $employee->id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if (!$salarySlip) {
            return back()->with('error', 'No salary slip found for the selected employee and month.');
        }

        $salaryPerDay = $employee->net_salary / 30;
        $salaryPerHour = $salaryPerDay / 8;
        $authorizedAbsenceDeduction = $salaryPerDay * $salarySlip->auth_leave;
        $unauthorizedAbsenceDeduction = ($salaryPerDay * $salarySlip->unauth_leave) + (0.25 * $salaryPerDay);
        $lateDeduction = $salaryPerHour * $salarySlip->late_in_early_out_deduction;
        $overtimePay = ($salaryPerHour * $salarySlip->overtime + (0.25 * $salaryPerHour));
        $loan = Loan::where('employee_id', $employee->id)
            ->where('company_id', $employee->company_id)
            ->first();
        $loanDeduction = $loan ? $loan->amount : 0;
        $taxSlab = SalaryTaxSlab::where('company_id', $employee->company_id)
            ->where('slab_start', '<=', $employee->net_salary)
            ->where('slab_end', '>=', $employee->net_salary)
            ->first();
        $incomeTax = $taxSlab ? $salarySlip->income_tax : 0;
        $totalDeductions = $authorizedAbsenceDeduction + $unauthorizedAbsenceDeduction + $lateDeduction + $loanDeduction + $incomeTax;
        $netSalary = $employee->net_salary;
        $totalDebit = $authorizedAbsenceDeduction + $unauthorizedAbsenceDeduction + $lateDeduction + $salarySlip->loan_advance + $incomeTax;
        $totalCredit = $netSalary + $overtimePay + $salarySlip->arrears;
        $totalSalary = $totalCredit - $totalDebit;
        $totalSalaryRounded = round($totalSalary, 2);
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $integerPart = floor($totalSalaryRounded);
        $totalSalaryInWords = $formatter->format($integerPart);
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
            'authorizedAbsenceDeduction',
            'unauthorizedAbsenceDeduction',
            'lateDeduction',
            'overtimePay',
            'loanDeduction',
            'incomeTax',
            'totalSalaryInWords'
        ));
    }
}
