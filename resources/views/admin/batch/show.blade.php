@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Batch Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('batches.index') }}">Batches</a></li>
                    <li class="breadcrumb-item active">Batch Details</li>
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
                            <input type="text" class="form-control" value="{{ $batch->company->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Product</label>
                            <input type="text" class="form-control" value="{{ $batch->product->brand_name ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>Batch No</label>
                            <input type="text" class="form-control" value="{{ $batch->batch_no ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>Batch Size</label>
                            <input type="text" class="form-control" value="{{ $batch->batch_size ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>MFG date</label>
                            <input type="text" class="form-control" value="{{ $batch->mfg_date ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>EXP date</label>
                            <input type="text" class="form-control" value="{{ $batch->exp_date ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Status</label>
                            <input type="text" class="form-control" value="{{ $batch->status ?? 'N/A' }}" readonly>
                        </div>

                        
                    </div>
                    <a class="btn btn-secondary" href="{{ route('batches.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection