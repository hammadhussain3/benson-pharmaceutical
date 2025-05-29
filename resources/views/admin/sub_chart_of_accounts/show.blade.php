@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Sub Chart of Account Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sub_chart_of_accounts.index') }}">Sub Chart of Accounts</a></li>
                    <li class="breadcrumb-item active">Sub Chart of Account Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        @role('Superadmin')
                        <div class="mb-3 col-md-12">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $subChartOfAccount->company->name }}" readonly>
                        </div>
                        @endrole
                        <div class="mb-3 col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $subChartOfAccount->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Abbreviation</label>
                            <input type="text" class="form-control" value="{{ $subChartOfAccount->chart_of_account->particular }}" readonly>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('sub_chart_of_accounts.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection