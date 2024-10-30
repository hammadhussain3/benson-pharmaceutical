@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Salary Sheet</h4>
            <h6>View your Salary Sheet</h6>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Salary Sheet</button>
        </div>
    </div>
    <!-- Print Button -->


    <!-- Card Component -->
    <div class="card">
        <div class="card-body">

            <div class="row justify-content-between">
                <div class="col-auto">
                    <img src="{{ asset($company->logo_path ? 'images/company/' . $company->logo_path : 'images/company/logo.png') }}" class="mb-2" style="height: 100px">
                    <h5 class="fw-bold">{{ $company->name }}</h5>
                    <h5>{{ $company->address }}</h5>
                    <h5>{{ $company->phone }}</h5>
                </div>
                <div class="col-auto text-end">
                    <h2>Salary Sheet</h2>
                    <h5>Month: {{ $formattedMonth }}</h5>
                </div>
            </div>
       
            <table class="table mt-5">
                <tr>
                    <th>Name</th>
                    <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                    <th>Employee No</th>
                    <td>{{ $employee->code }}</td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td>{{ $employee->department->name }}</td>
                    <th>Designation</th>
                    <td>{{ $employee->designation->name }}</td>
                    <th>Branch</th>
                    <td>{{ $employee->branch->name }}</td>
                </tr>
                <tr>
                    <th>Basic Pay</th>
                    <td>{{ number_format($employee->basic_pay, 2) }}</td>
                    <th>Allowances</th>
                    <td>{{ number_format($employee->allowances, 2) }}</td>
                    <th>Net Salary</th>
                    <td>{{ number_format($netSalary, 2) }}</td>
                </tr>
                <tr>
                    <th>Salary per Day</th>
                    <td colspan="3">{{ number_format($salaryPerDay, 2) }}</td>
                </tr>
            </table>

            <hr>
            <table class="table table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Description</th>
                        <th>Days</th>
                        <th>Hours</th>
                        <th>Amount per Day</th>
                        <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Gross Salary</td>
                        <td>{{ $daysInMonth }}</td>
                        <td>-</td>
                        <td>{{ number_format($salaryPerDay, 2) }}</td>
                        <td>-</td>
                        <td>{{ number_format($netSalary, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Authorized Absence</td>
                        <td>{{ $salarySlip->auth_leave }}</td>
                        <td>-</td>
                        <td>{{ number_format($salaryPerDay, 2) }}</td>
                        <td>{{ number_format($authorizedAbsenceDeduction, 2) }}</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Unauth. Absence</td>
                        <td>{{ $salarySlip->unauth_leave }}</td>
                        <td>-</td>
                        <td>{{ number_format($salaryPerDay * 1.25, 2) }}</td>
                        <td>{{ number_format($unauthorizedAbsenceDeduction, 2) }}</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Late In / Early Out</td>
                        <td></td>
                        <td>{{ $salarySlip->late_in_early_out_deduction }}</td>
                        <td></td>
                        <td>{{ number_format($lateDeduction, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Overtime</td>
                        <td></td>
                        <td>{{ $salarySlip->overtime }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ number_format($overtimePay, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Arrears</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ number_format($salarySlip->arrears, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Loan/Advance</td>
                        <td colspan="3"></td>
                        <td>{{ number_format($salarySlip->loan_advance, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Income Tax Deducted</td>
                        <td colspan="3"></td>
                        <td>{{ number_format($incomeTax, 2) }}</td>
                        <td></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right"> <strong>Total</strong></th>
                        <th>{{ number_format($totalDebit, 2) }}</th>
                        <th>{{ number_format($totalCredit, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right"> <strong>Total Salary:</strong></th>
                        <th colspan="2">{{ number_format($totalSalaryRounded, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right"> <strong>Total Salary in Words:</strong></th>
                        <td colspan="2">{{ ucfirst($totalSalaryInWords) }}</td>
                    </tr>
                </tfoot>
            </table>
            <hr>
            <div class="text-right">
                <strong>Payment Mode:</strong> {{ $salarySlip->payment_mode }}
            </div>
            <br>
            <br>
            <div style="display: flex; justify-content: space-around; margin-top: 50px;">
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Prepared by</span>
                </div>
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Checked by</span>
                </div>
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Approved by</span>
                </div>
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Received by</span>
                </div>
            </div>

            <div style="margin-top: 30px; font-size: 14px;">
                <strong>Note:</strong> Claims (if any) must be lodged with the departmental head within seven (7) days
                from the receipt of the above amount.
            </div>
        </div>
    </div>
@endsection

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .card,
        .card * {
            visibility: visible;
        }

        .card {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>