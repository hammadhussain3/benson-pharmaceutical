@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Loan</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('loans.index') }}">Loans</a></li>
                    <li class="breadcrumb-item active">Add Loan</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('loans.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            <div class="mb-3 col-md-12">
                                <label for="employee_id">Employee</label>
                                <select name="employee_id" id="employee_id" class="js-example-basic-single select2"
                                    required @role('Superadmin') onchange="SelectCompany(this.value);" @endrole>
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->code }} -
                                            {{ $employee->first_name }} {{ $employee->last_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select an employee.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" name="amount" id="amount"
                                    placeholder="Loan Amount" required>
                                <div class="invalid-feedback">Please provide a valid amount.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="payback_months">Payback Months</label>
                                <input type="number" class="form-control" name="payback_months" id="payback_months"
                                    placeholder="Payback Months" required>
                                <div class="invalid-feedback">Please provide the number of payback months.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="remaining">Remaining</label>
                                <input type="number" class="form-control" name="remaining" id="remaining"
                                    placeholder="Remaining Amount" required>
                                <div class="invalid-feedback">Please provide the remaining amount.</div>
                            </div>
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company_id">Company</label>
                                <input type="text" class="form-control" name="company" id="company" required readonly>
                                <input type="hidden" name="company_id" id="company_id" required>
                            </div>
                            @else
                                <input type="hidden" name="company_id" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('loans.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
