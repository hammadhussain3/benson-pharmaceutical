@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Tax Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('taxes.index') }}">Taxes</a></li>
                    <li class="breadcrumb-item active">Tax Details</li>
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
                            <input type="text" class="form-control" value="{{ $tax->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Rate</label>
                            <input type="text" class="form-control" value="{{ $tax->rate }}" readonly>
                        </div>
                        @role('Superadmin')
                        <div class="mb-3 col-md-12">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $tax->company->name }}" readonly>
                        </div>
                        @endrole
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Tax Update'))
                            <a class="btn btn-primary" href="{{ route('taxes.edit', $tax->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('taxes.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Tax Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $tax->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $tax->id }}"
                                action="{{ route('taxes.destroy', $tax->id) }}" method="POST"
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
