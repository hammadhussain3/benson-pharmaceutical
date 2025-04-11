@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">View Sub Category</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sub-categories.index') }}">Sub Categories</a></li>
                    <li class="breadcrumb-item active">View Sub Category</li>
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
                            <label for="category">Category</label>
                            <input type="text" class="form-control" value="{{ $subCategory->category->name }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="prefix">Prefix</label>
                            <input type="text" class="form-control" value="{{ $subCategory->prefix }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" value="{{ $subCategory->name }}" readonly>
                        </div>
                        
                        <div class="mb-3 col-md-12">
                            <label for="description">Description</label>
                            <textarea class="form-control" disabled>{{ $subCategory->description }}</textarea>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('sub-categories.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection