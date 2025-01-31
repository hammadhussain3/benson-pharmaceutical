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
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $stock->product->name ?? $stock->rawMaterialItem->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Quantity</label>
                            <input type="text" class="form-control" value="{{ $stock->quantity }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Unit</label>
                            <input type="text" class="form-control" value="{{ $stock->unit }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Unit Price</label>
                            <input type="text" class="form-control" value="{{ $stock->unit_price }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Total</label>
                            <input type="text" class="form-control" value="{{ $stock->total }}" readonly>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('stocks.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection