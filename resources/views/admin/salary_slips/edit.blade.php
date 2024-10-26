@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Salary Slip</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('salary_slips.index') }}">Salary Slips</a></li>
                    <li class="breadcrumb-item active">Edit Salary Slip</li>
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
                                <select name="employee_id" id="employee" class="js-example-basic-single select2" required onchange="SelectLoan(this.value); SelecLeaves(this.value); SelectIncomeTax(this.value); SelectCompany(this.value); SelectEmployeeDetails(this.value);">
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ $salarySlip->employee_id == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->code }} - {{ $employee->first_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select an employee.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="month">Month</label>
                                <input type="month" name="month" id="month" class="form-control" min="{{ date('Y-m', strtotime($currentEmployee->date_of_joining)) }}" max="{{ date('Y-m', strtotime('-1 month')) }}"
                                       value="{{ $salarySlip->year . '-' . str_pad($salarySlip->month, 2, '0', STR_PAD_LEFT) }}" required>
                                <div class="invalid-feedback">Please select a month.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="payment_mode">Payment Mode</label>
                                <select name="payment_mode" id="payment_mode" class="form-control" required>
                                    <option value="">Select Payment Mode</option>
                                    <option value="bank_transfer"
                                        {{ $salarySlip->payment_mode == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                                    </option>
                                    <option value="cash" {{ $salarySlip->payment_mode == 'cash' ? 'selected' : '' }}>Cash
                                    </option>
                                </select>
                                <div class="invalid-feedback">Please select a payment mode.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="arrears">Arrears</label>
                                <input type="number" class="form-control" name="arrears" id="arrears"
                                    value="{{ $salarySlip->arrears }}" required>
                                <div class="invalid-feedback">Please provide the arrears amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="late_in_early_out_deduction">Late/Early Out Deduction</label>
                                <input type="number" class="form-control" name="late_in_early_out_deduction"
                                    id="late_in_early_out_deduction" value="{{ $salarySlip->late_in_early_out_deduction }}"
                                    required>
                                <div class="invalid-feedback">Please provide the deduction amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="overtime">Overtime</label>
                                <input type="number" class="form-control" name="overtime" id="overtime"
                                    value="{{ $salarySlip->overtime }}" required>
                                <div class="invalid-feedback">Please provide the overtime amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="income_tax">Income Tax</label>
                                <input type="number" class="form-control" name="income_tax" id="income_tax"
                                    value="{{ $salarySlip->income_tax }}" required readonly>
                                <div class="invalid-feedback">Please provide the income tax amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="loan_advance">Loan/Advance</label>
                                <input type="number" class="form-control" name="loan_advance" id="loan_advance"
                                    value="{{ $salarySlip->loan_advance }}" required readonly >
                                <div class="invalid-feedback">Please provide the loan/advance amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="auth_leave">Approved Leave</label>
                                <input type="number" class="form-control" name="auth_leave" id="auth_leave"
                                    value="{{ $salarySlip->auth_leave }}" required readonly>
                                <div class="invalid-feedback">Please provide the number of approved leaves.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="unauth_leave">Unauthorized Leave</label>
                                <input type="number" class="form-control" name="unauth_leave" id="unauth_leave"
                                    value="{{ $salarySlip->unauth_leave }}" required readonly>
                                <div class="invalid-feedback">Please provide the number of unauthorized leaves.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="approved_with_pay">Approved with Pay</label>
                                <input type="number" class="form-control" name="approved_with_pay" id="approved_with_pay"
                                    value="{{ $salarySlip->approved_with_pay }}" required readonly>
                                <div class="invalid-feedback">Please provide the approved amount with pay.</div>
                            </div> 

                            <div class="mb-3 col-md-6">
                                <label for="basic_pay">Basic Pay</label>
                                <input type="number" class="form-control" name="basic_pay" id="basic_pay"
                                    value="{{ $currentEmployee->basic_pay }}" required readonly>
                                <div class="invalid-feedback">Please provide the number of basic pay.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="allowances">Allowances</label>
                                <input type="number" class="form-control" name="allowances" id="allowances"
                                    value="{{ $currentEmployee->allowances }}" required readonly>
                                <div class="invalid-feedback">Please provide the number of allowances.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                <select name="company_id" id="company_id" class="js-example-basic-single select2" required disabled>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $salarySlip->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="branch_id">Branch</label>
                                <select name="branch_id" id="branch_id" class="js-example-basic-single select2" required disabled>
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ $currentEmployee->branch_id == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a Branch.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="department_id">Department</label>
                                <select name="department_id" id="department_id" class="js-example-basic-single select2" required disabled>
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $currentEmployee->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a Department.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="designation_id">Designation</label>
                                <select name="designation_id" id="designation_id" class="js-example-basic-single select2" required disabled>
                                    <option value="">Select Designation</option>
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}"
                                            {{ $currentEmployee->designation_id == $designation->id ? 'selected' : '' }}>
                                            {{ $designation->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a Designation.</div>
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
