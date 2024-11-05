@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Payment Type Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('payment_types.index') }}">Payment Types</a></li>
                    <li class="breadcrumb-item active">Payment Type Details</li>
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
                            <label>Payment Type Name</label>
                            <input type="text" class="form-control" value="{{ $paymentType->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label>Description</label>
                            <textarea class="form-control" readonly>{{ $paymentType->description ?? 'N/A' }}</textarea>                            
                        </div>
                        @role('Superadmin')
                        <div class="mb-3 col-md-12">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $paymentType->company->name ?? 'N/A' }}" readonly>
                        </div>
                        @endrole
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Payment Types Update'))
                            <a class="btn btn-primary" href="{{ route('payment_types.edit', $paymentType->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('payment_types.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Payment Types Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $paymentType->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $paymentType->id }}"
                                action="{{ route('payment_types.destroy', $paymentType->id) }}" method="POST"
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