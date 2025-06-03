@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Supplier Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Suppliers</a></li>
                    <li class="breadcrumb-item active">Supplier Details</li>
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
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $supplier->company->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Chart Of Account</label>
                            <input type="text" class="form-control" value="{{ $supplier->chart_of_account->particular ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Sub Chart Of Account</label>
                            <input type="text" class="form-control" value="{{ optional($supplier->sub_chart_of_account)->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $supplier->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Phone</label>
                            <input type="text" class="form-control" value="{{ $supplier->phone ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ $supplier->email ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Country</label>
                            <input type="text" class="form-control" value="{{ $supplier->country->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>City</label>
                            <input type="text" class="form-control" value="{{ $supplier->city->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Address</label>
                            <textarea class="form-control" readonly>{{ $supplier->address ?? 'N/A' }}</textarea>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Payment Type</label>
                            <input type="text" class="form-control" value="{{ $supplier->paymentType->name ?? 'N/A' }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Supplier Update'))
                            <a class="btn btn-primary" href="{{ route('suppliers.edit', $supplier->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('suppliers.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Supplier Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $supplier->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $supplier->id }}"
                                action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
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