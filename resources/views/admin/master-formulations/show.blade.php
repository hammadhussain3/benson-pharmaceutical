@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Master Formulation Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('master-formulations.index') }}">Master Formulations</a></li>
                    <li class="breadcrumb-item active">View Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Master Formulation Information</h4>
                    <div class="card-actions">
                        <a href="{{ route('master-formulations.edit', $masterFormulation->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('master-formulations.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Product:</label>
                                <span class="info-value">{{ $masterFormulation->product->name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Brand Name:</label>
                                <span class="info-value">{{ $masterFormulation->product->brand_name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Batch Size:</label>
                                <span class="info-value">{{ $masterFormulation->batch_size }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Product Quantity:</label>
                                <span class="info-value">{{ $masterFormulation->product_quantity }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Created By:</label>
                                <span class="info-value">{{ $masterFormulation->creator->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Created At:</label>
                                <span class="info-value">{{ $masterFormulation->created_at->format('d M, Y H:i A') }}</span>
                            </div>
                        </div>
                        @if($masterFormulation->updated_by)
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Updated By:</label>
                                <span class="info-value">{{ $masterFormulation->updater->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Updated At:</label>
                                <span class="info-value">{{ $masterFormulation->updated_at->format('d M, Y H:i A') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



    <style>
        .info-item {
            margin-bottom: 15px;
        }
        .info-label {
            font-weight: 600;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }
        .info-value {
            color: #666;
            font-size: 14px;
        }
        .card-actions {
            display: flex;
            gap: 10px;
        }
    </style>
@endsection
