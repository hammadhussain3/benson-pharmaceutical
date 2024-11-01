@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Salary</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('salary_slips.index') }}">Salaries</a></li>
                    <li class="breadcrumb-item active">Add Salary</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('salary_slips.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">

                            <div class="col-md-6">
                                <label>Select Employee </label>
                                <select name="employee" id="employee_id" class="js-example-basic-single select2" required onchange="SelectLoan(this.value); SelecLeaves(this.value); SelectIncomeTax(this.value); @role('Superadmin') SelectCompany(this.value); @endrole SelectEmployeeDetails(this.value);">
                                    <option value="">--Select Employee--</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('employee') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->code }} -
                                            {{ $employee->first_name }}
                                            {{ $employee->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @php
                                $currentMonth = date('n');
                                $currentYear = date('Y');
                            @endphp

                            <div class="mb-3 col-md-6">
                                <label for="month">Month and Year</label>
                                <select class="form-select" name="month" id="month" onchange="SelectLoanDate(this.value);">
                                    @foreach(['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'] as $key => $month)
                                        @php
                                            // Determine the year for each month
                                            $year = $key > $currentMonth ? $currentYear - 1 : $currentYear;
                                            // Format the value as YYYY-MM
                                            $formattedValue = sprintf('%04d-%02d', $year, $key);
                                        @endphp
                                        <option value="{{ $formattedValue }}" 
                                            {{ old('month', sprintf('%04d-%02d', $currentYear, $currentMonth)) == $formattedValue ? 'selected' : '' }}>
                                            {{ $month }} {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a month.</div>
                            </div>

                            {{-- <div class="mb-3 col-md-6">
                                <label for="month">Month</label>
                                <input type="month" name="month" id="month" class="form-control" max="{{ date('Y-m', strtotime('-1 month')) }}" required onchange="SelectLoanDate(this.value);">
                                <div class="invalid-feedback">Please select a month.</div>
                            </div> --}}

                            <div class="mb-3 col-md-6">
                                <label for="payment_mode">Payment Mode</label>
                                <select name="payment_mode" id="payment_mode" class="form-control" required>
                                    <option value="">Select Payment Mode</option>
                                    <option value="bank_transfer" {{ old('payment_mode') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                                </select>
                                <div class="invalid-feedback">Please select a payment mode.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="arrears">Arrears</label>
                                <input type="number" class="form-control" name="arrears" id="arrears" required value="{{ old('arrears') }}">
                                <div class="invalid-feedback">Please provide the arrears amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="late_in_early_out_deduction">Late/Early Out Deduction</label>
                                <input type="number" class="form-control" name="late_in_early_out_deduction"
                                    id="late_in_early_out_deduction" required value="{{ old('late_in_early_out_deduction') }}">
                                <div class="invalid-feedback">Please provide the deduction amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="overtime">Overtime</label>
                                <input type="number" class="form-control" name="overtime" id="overtime" required value="{{ old('overtime') }}">
                                <div class="invalid-feedback">Please provide the overtime amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="income_tax">Income Tax</label>
                                <input type="number" class="form-control" name="income_tax" id="income_tax" required readonly>
                                <div class="invalid-feedback">Please provide the income tax amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="loan_advance">Loan/Advance</label>
                                <input type="number" class="form-control" name="loan_advance" id="loan_advance" required readonly>
                                <div class="invalid-feedback">Please provide the loan/advance amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="auth_leave">Approved Leave</label>
                                <input type="number" class="form-control" name="auth_leave" id="auth_leave" required readonly>
                                <div class="invalid-feedback">Please provide the number of approved leaves.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="unauth_leave">Unauthorized Leave</label>
                                <input type="number" class="form-control" name="unauth_leave" id="unauth_leave" required readonly>
                                <div class="invalid-feedback">Please provide the number of unauthorized leaves.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="approved_with_pay">Approved with Pay</label>
                                <input type="number" class="form-control" name="approved_with_pay" id="approved_with_pay"
                                    required readonly>
                                <div class="invalid-feedback">Please provide the approved amount with pay.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="basic_pay">Basic Pay</label>
                                <input type="number" class="form-control" name="basic_pay" id="basic_pay" required readonly>
                                <div class="invalid-feedback">Please provide the number of basic pay.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="allowances">Allowances</label>
                                <input type="number" class="form-control" name="allowances" id="allowances" required readonly>
                                <div class="invalid-feedback">Please provide the number of allowances.</div>
                            </div>

                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company">Company</label>
                                <input type="text" class="form-control" id="company" required readonly>
                                <input type="hidden" name="company" id="company_id" required>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole

                            <div class="mb-3 col-md-6">
                                <label for="branch">Branch</label>
                                <input type="text" class="form-control" name="branch" id="branch" required readonly>
                                <input type="hidden" name="branch_id" id="branch_id" required>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" name="department" id="department" required readonly>
                                <input type="hidden" name="department_id" id="department_id" required>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="designation">Designation</label>
                                <input type="text" class="form-control" name="designation" id="designation" required readonly>
                                <input type="hidden" name="designation_id" id="designation_id" required>
                            </div>

                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('salary_slips.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
