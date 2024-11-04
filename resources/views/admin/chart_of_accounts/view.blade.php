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
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $chartOfAccount->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Code</label>
                            <input type="text" class="form-control" value="{{ $chartOfAccount->code }}" readonly>
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
                            <a class="btn btn-primary" href="{{ route('chart_of_accounts.edit', $chartOfAccount->id) }}">Update</a>
                            <a class="btn btn-secondary" href="{{ route('chart_of_accounts.index') }}">Cancel</a>
                        </div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection