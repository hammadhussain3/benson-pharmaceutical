@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Salary Slip</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('salary_slips.index') }}">Salary Slips</a></li>
                    <li class="breadcrumb-item active">Add Salary Slip</li>
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
                                <select name="employee_id" id="employee" class="js-example-basic-single select2" required>
                                    <option value="">--Select Employee--</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->code }} -
                                            {{ $employee->first_name }}
                                            {{ $employee->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="auth_leave">Approved Leave</label>
                                <input type="number" class="form-control" name="auth_leave" id="auth_leave" required>
                                <div class="invalid-feedback">Please provide the number of approved leaves.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="unauth_leave">Unauthorized Leave</label>
                                <input type="number" class="form-control" name="unauth_leave" id="unauth_leave" required>
                                <div class="invalid-feedback">Please provide the number of unauthorized leaves.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="approved_with_pay">Approved with Pay</label>
                                <input type="number" class="form-control" name="approved_with_pay" id="approved_with_pay"
                                    required>
                                <div class="invalid-feedback">Please provide the approved amount with pay.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="late_in_early_out_deduction">Late/Early Out Deduction</label>
                                <input type="number" class="form-control" name="late_in_early_out_deduction"
                                    id="late_in_early_out_deduction" required>
                                <div class="invalid-feedback">Please provide the deduction amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="overtime">Overtime</label>
                                <input type="number" class="form-control" name="overtime" id="overtime" required>
                                <div class="invalid-feedback">Please provide the overtime amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="arrears">Arrears</label>
                                <input type="number" class="form-control" name="arrears" id="arrears" required>
                                <div class="invalid-feedback">Please provide the arrears amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="income_tax">Income Tax</label>
                                <input type="number" class="form-control" name="income_tax" id="income_tax" required>
                                <div class="invalid-feedback">Please provide the income tax amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="loan_advance">Loan/Advance</label>
                                <input type="number" class="form-control" name="loan_advance" id="loan_advance" required>
                                <div class="invalid-feedback">Please provide the loan/advance amount.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="payment_mode">Payment Mode</label>
                                <select name="payment_mode" id="payment_mode" class="form-control" required>
                                    <option value="">Select Payment Mode</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="cash">Cash</option>
                                </select>
                                <div class="invalid-feedback">Please select a payment mode.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="company">Company</label>
                                <select name="company_id" id="company" class="js-example-basic-single select2" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
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
