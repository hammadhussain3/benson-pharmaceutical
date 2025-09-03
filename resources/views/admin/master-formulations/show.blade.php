@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Master Formulation Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('master-formulations.index') }}">Master Formulations</a></li>
                    <li class="breadcrumb-item active">Master Formulation Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Brand</label>
                                <input type="text" class="form-control" value="{{ $masterFormulation->brand_name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Product (manual)</label>
                                <input type="text" class="form-control" value="{{ $masterFormulation->product_name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Batch Size</label>
                                <input type="text" class="form-control" value="{{ $masterFormulation->batch_size }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Created At</label>
                                <input type="text" class="form-control" value="{{ $masterFormulation->created_at->format('d M, Y') }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <a href="{{ route('master-formulations.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
