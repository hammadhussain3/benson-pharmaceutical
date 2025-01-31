@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Raw Material Item Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('raw-material-items.index') }}">Raw Material Items</a></li>
                    <li class="breadcrumb-item active">Raw Material Item Details</li>
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
                            <input type="text" class="form-control" value="{{ $rawMaterialItem->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Code</label>
                            <input type="text" class="form-control" value="{{ $rawMaterialItem->code }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Unit</label>
                            <input type="text" class="form-control" value="{{ $rawMaterialItem->unit }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Min Level</label>
                            <input type="text" class="form-control" value="{{ $rawMaterialItem->min_level }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Max Level</label>
                            <input type="text" class="form-control" value="{{ $rawMaterialItem->max_level }}" readonly>
                        </div>
                        @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label>Company</label>
                                <input type="text" class="form-control" value="{{ $rawMaterialItem->company->name }}" readonly>
                            </div>
                        @endrole
                        <div class="mb-3 col-md-6">
                            <label>Party</label>
                            <input type="text" class="form-control" value="{{ $rawMaterialItem->party->name }}" readonly>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('raw-material-items.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection