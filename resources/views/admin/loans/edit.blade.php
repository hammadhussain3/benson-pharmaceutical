@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Loan</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('loans.index') }}">Loans</a></li>
                    <li class="breadcrumb-item active">Edit Loan</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('loans.update', $loan->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-12">
                                <label for="employee_id">Employee</label>
                                <select name="employee_id" id="employee_id" class="js-example-basic-single select2"
                                    required @role('Superadmin') onchange="SelectCompany(this.value);" @endrole>
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ $employee->id == $loan->employee_id ? 'selected' : '' }}>
                                            {{ $employee->code }} - {{ $employee->first_name }} {{ $employee->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select an employee.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" name="amount" id="amount"
                                    value="{{ $loan->amount }}" required>
                                <div class="invalid-feedback">Please provide a valid amount.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="payback_months">Payback Months</label>
                                <input type="number" class="form-control" name="payback_months" id="payback_months"
                                    value="{{ $loan->payback_months }}" required>
                                <div class="invalid-feedback">Please provide the number of payback months.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="remaining">Remaining</label>
                                <input type="number" class="form-control" name="remaining" id="remaining"
                                    value="{{ $loan->remaining }}" required>
                                <div class="invalid-feedback">Please provide the remaining amount.</div>
                            </div>
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company_id">Company</label>
                                <input type="text" class="form-control" id="company" value="{{ App\Models\Company::where('id', $loan->company_id)->value('name') }}" required readonly>
                                <input type="hidden" name="company" id="company_id" value="{{ $loan->company_id }}" required>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ $loan->company_id }}">
                            @endrole
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('loans.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
