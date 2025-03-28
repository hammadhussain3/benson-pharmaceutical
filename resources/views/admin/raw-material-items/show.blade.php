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
                        @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label>Company</label>
                                <input type="text" class="form-control" value="{{ $rawMaterialItem->company->name }}" readonly>
                            </div>
                        @endrole
                        <div class="mb-3 col-md-6">
                            <label>Category</label>
                            <input type="text" class="form-control" value="{{ $rawMaterialItem->category->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Code</label>
                            <input type="text" class="form-control" value="{{  $rawMaterialItem->category->prefix . '-' . $rawMaterialItem->code }}" readonly>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $rawMaterialItem->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label>Unit</label>
                            <input type="text" class="form-control" value="{{ $rawMaterialItem->unit }}" readonly>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label>Party</label>
                            <input type="text" class="form-control" value="{{ $rawMaterialItem->party->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Min Level</label>
                            <input type="text" class="form-control" value="{{ $rawMaterialItem->min_level }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Max Level</label>
                            <input type="text" class="form-control" value="{{ $rawMaterialItem->max_level }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label>Description</label>
                            <textarea class="form-control" readonly>{{ $rawMaterialItem->description }}</textarea>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('raw-material-items.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection