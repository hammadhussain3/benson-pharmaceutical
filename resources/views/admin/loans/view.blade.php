@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Loan Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('loans.index') }}">Loans</a></li>
                    <li class="breadcrumb-item active">Loan Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        <div class="mb-3 col-md-12">
                            <label>Employee</label>
                            <input type="text" class="form-control" value="{{ $loan->employee->code }} - {{ $loan->employee->first_name }} {{ $loan->employee->last_name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label>Amount</label>
                            <input type="text" class="form-control" value="{{ $loan->amount ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label>Payback Months</label>
                            <input type="text" class="form-control" value="{{ $loan->payback_months ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label>Remaining</label>
                            <input type="text" class="form-control" value="{{ $loan->remaining ?? 'N/A' }}" readonly>
                        </div>
                        @role('Superadmin')
                        <div class="mb-3 col-md-12">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $loan->company->name ?? 'N/A' }}" readonly>
                        </div>
                        @endrole
                    </div>
                    <a class="btn btn-secondary" href="{{ route('loans.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection