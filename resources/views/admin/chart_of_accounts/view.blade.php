@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Chart of Account Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('chart_of_accounts.index') }}">Chart of Accounts</a></li>
                    <li class="breadcrumb-item active">Chart of Account Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        <div class="mb-3 col-md-6">
                            <label>Particular</label>
                            <input type="text" class="form-control" value="{{ $chartOfAccount->particular }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Code</label>
                            <input type="text" class="form-control" value="{{ $chartOfAccount->code }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Abbreviation</label>
                            <input type="text" class="form-control" value="{{ $chartOfAccount->abbreviation }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Budget</label>
                            <input type="text" class="form-control" value="{{ $chartOfAccount->budget }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Open Debit</label>
                            <input type="text" class="form-control" value="{{ $chartOfAccount->open_debit }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Open Credit</label>
                            <input type="text" class="form-control" value="{{ $chartOfAccount->open_credit }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Act Debit</label>
                            <input type="text" class="form-control" value="{{ $chartOfAccount->act_debit }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Act Credit</label>
                            <input type="text" class="form-control" value="{{ $chartOfAccount->act_credit }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>CL Debit</label>
                            <input type="text" class="form-control" value="{{ $chartOfAccount->cl_debit }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>CL Credit</label>
                            <input type="text" class="form-control" value="{{ $chartOfAccount->cl_credit }}" readonly>
                        </div>
                        @role('Superadmin')
                        <div class="mb-3 col-md-6">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $chartOfAccount->company->name }}" readonly>
                        </div>
                        @endrole
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Chart Of Accounts Update'))
                            <a class="btn btn-primary" href="{{ route('chart_of_accounts.edit', $chartOfAccount->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('chart_of_accounts.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Chart Of Accounts Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $chartOfAccount->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $chartOfAccount->id }}"
                                action="{{ route('chart_of_accounts.destroy', $chartOfAccount->id) }}" method="POST"
                                style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection