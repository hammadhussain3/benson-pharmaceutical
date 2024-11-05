@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Salary</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('salary_slips.index') }}">Salaries</a></li>
                    <li class="breadcrumb-item active">Edit Salary</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('salary_slips.update', $salarySlip->id) }}" method="POST"
                        class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">

                            <div class="mb-3 col-md-6">
                                <label for="employee">Employee</label>
                                <select name="employee" id="employee" class="js-example-basic-single select2" required onchange="SelectLoan(this.value); SelecLeaves(this.value); SelectIncomeTax(this.value); @role('Superadmin') SelectCompany(this.value); @endrole SelectEmployeeDetails(this.value);">
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('employee', $salarySlip->employee_id) == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->code }} - {{ $employee->first_name }} {{ $employee->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select an employee.</div>
                            </div>

                            @php
                                $currentMonth = date('n');
                                $currentYear = date('Y');
                                $selectedMonth = old('month', sprintf('%04d-%02d', $salarySlip->year ?? $currentYear, $salarySlip->month ?? $currentMonth));
                            @endphp

                            <div class="mb-3 col-md-6">
                                <label for="month">Month and Year</label>
                                <select class="form-select" name="month" id="month">
                                    @foreach(['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'] as $key => $month)
                                        @php
                                            // Determine the year for each month
                                            $year = $key > $currentMonth ? $currentYear - 1 : $currentYear;
                                            // Format the value as YYYY-MM
                                            $formattedValue = sprintf('%04d-%02d', $year, $key);
                                        @endphp
                                        <option value="{{ $formattedValue }}" 
                                            {{ $formattedValue == $selectedMonth ? 'selected' : '' }}>
                                            {{ $month }} {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a month.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="payment_mode">Payment Mode</label>
                                <select name="payment_mode" id="payment_mode" class="form-control" required>
                                    <option value="">Select Payment Mode</option>
                                    <option value="bank_transfer"
                                        {{ old('payment_mode', $salarySlip->payment_mode) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                                    </option>
                                    <option value="cash" {{ old('payment_mode', $salarySlip->payment_mode) == 'cash' ? 'selected' : '' }}>Cash
                                    </option>
                                </select>
                                <div class="invalid-feedback">Please select a payment mode.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="arrears">Arrears</label>
                                <input type="number" class="form-control" name="arrears" id="arrears"
                                    value="{{ old('arrears', $salarySlip->arrears) }}" required>
                                <div class="invalid-feedback">Please provide the arrears amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="late_in_early_out_deduction">Late/Early Out Deduction</label>
                                <input type="number" class="form-control" name="late_in_early_out_deduction"
                                    id="late_in_early_out_deduction" value="{{ old('late_in_early_out_deduction', $salarySlip->late_in_early_out_deduction) }}"
                                    required>
                                <div class="invalid-feedback">Please provide the deduction amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="overtime">Overtime</label>
                                <input type="number" class="form-control" name="overtime" id="overtime"
                                    value="{{ old('overtime', $salarySlip->overtime) }}" required>
                                <div class="invalid-feedback">Please provide the overtime amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="income_tax">Income Tax</label>
                                <input type="number" class="form-control" name="income_tax" id="income_tax"
                                    value="{{ old('income_tax', $salarySlip->income_tax) }}" required readonly>
                                <div class="invalid-feedback">Please provide the income tax amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="loan_advance">Loan/Advance</label>
                                <input type="number" class="form-control" name="loan_advance" id="loan_advance"
                                    value="{{ old('loan_advance', $salarySlip->loan_advance) }}" required readonly >
                                <div class="invalid-feedback">Please provide the loan/advance amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="auth_leave">Approved Leave</label>
                                <input type="number" class="form-control" name="auth_leave" id="auth_leave"
                                    value="{{ old('auth_leave', $salarySlip->auth_leave) }}" required readonly>
                                <div class="invalid-feedback">Please provide the number of approved leaves.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="unauth_leave">Unauthorized Leave</label>
                                <input type="number" class="form-control" name="unauth_leave" id="unauth_leave"
                                    value="{{ old('unauth_leave', $salarySlip->unauth_leave) }}" required readonly>
                                <div class="invalid-feedback">Please provide the number of unauthorized leaves.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="approved_with_pay">Approved with Pay</label>
                                <input type="number" class="form-control" name="approved_with_pay" id="approved_with_pay"
                                    value="{{ old('approved_with_pay', $salarySlip->approved_with_pay) }}" required readonly>
                                <div class="invalid-feedback">Please provide the approved amount with pay.</div>
                            </div> 

                            <div class="mb-3 col-md-6">
                                <label for="basic_pay">Basic Pay</label>
                                <input type="number" class="form-control" name="basic_pay" id="basic_pay"
                                    value="{{ old('basic_pay', $currentEmployee->basic_pay) }}" required readonly>
                                <div class="invalid-feedback">Please provide the number of basic pay.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="allowances">Allowances</label>
                                <input type="number" class="form-control" name="allowances" id="allowances"
                                    value="{{ old('allowances', $currentEmployee->allowances) }}" required readonly>
                                <div class="invalid-feedback">Please provide the number of allowances.</div>
                            </div>

                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                @php
                                    $selectedCompanyId = old('company', $currentEmployee->company_id);
                                @endphp
                                <input type="text" class="form-control" id="company" value="{{ App\Models\Company::where('id', $selectedCompanyId)->value('name') }}" required readonly>
                                <input type="hidden" name="company" id="company_id" value="{{ $selectedCompanyId }}" required>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ $currentEmployee->company_id }}">
                            @endrole

                            <div class="mb-3 col-md-6">
                                <label for="branch">Branch</label>
                                <input type="text" class="form-control" name="branch" id="branch" required readonly value="{{ old('branch', $singleBranch->name) }}">
                                <input type="hidden" name="branch_id" id="branch_id" required value="{{ old('branch_id', $singleBranch->id) }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" name="department" id="department" required readonly value="{{ old('department', $singleDepartment->name) }}">
                                <input type="hidden" name="department_id" id="department_id" required value="{{ old('department_id', $singleDepartment->id) }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="designation">Designation</label>
                                <input type="text" class="form-control" name="designation" id="designation" required readonly value="{{ old('designation', $singleDesignation->name) }}">
                                <input type="hidden" name="designation_id" id="designation_id" required value="{{ old('designation_id', $singleDesignation->id) }}">
                            </div>                                               

                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('salary_slips.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
