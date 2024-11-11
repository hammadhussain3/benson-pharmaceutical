@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Stock Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('stocks.index') }}">Stocks</a></li>
                    <li class="breadcrumb-item active">Stock Details</li>
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
                            <input type="text" class="form-control" value="{{ $stock->company->name }}" readonly>
                        </div>
                        @endrole
                        <div class="mb-3 col-md-6">
                            <label>Product</label>
                            <input type="text" class="form-control" value="{{ $stock->product->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Raw Material</label>
                            <input type="text" class="form-control" value="{{ $stock->rawMaterialItem->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Available Quantity</label>
                            <input type="text" class="form-control" value="{{ $stock->available_quantity }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Unit</label>
                            <input type="text" class="form-control" value="{{ $stock->unit }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Rate</label>
                            <input type="text" class="form-control" value="{{ $stock->rate }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Value</label>
                            <input type="text" class="form-control" value="{{ $stock->value }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Min. Level</label>
                            <input type="text" class="form-control" value="{{ $stock->min_level }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Max. Level</label>
                            <input type="text" class="form-control" value="{{ $stock->max_level }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Stock Update'))
                            <a class="btn btn-primary" href="{{ route('stocks.edit', $stock->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('stocks.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Stock Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $stock->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $stock->id }}"
                                action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
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