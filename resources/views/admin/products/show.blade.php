@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Product</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">Add Product</li>
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
                            <input type="text" class="form-control" value="{{ $product->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Registration Number</label>
                            <input type="text" class="form-control" value="{{ $product->reg_no }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Generic Name</label>
                            <input type="text" class="form-control" value="{{ $product->generic_name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Brand Name</label>
                            <input type="text" class="form-control" value="{{ $product->brand_name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Therapeutic Class</label>
                            <input type="text" class="form-control" value="{{ $product->therapeutic_class }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Code</label>
                            <input type="text" class="form-control" value="{{ $product->code }}" readonly>
                        </div>
                        @role('Superadmin')
                        <div class="mb-3 col-md-6">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $product->company->name }}" readonly>
                        </div>
                        @endrole
                        <div class="mb-3 col-md-6">
                            <label>Product Group</label>
                            <input type="text" class="form-control" value="{{ $product->productGroup->name }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Product Update'))
                            <a class="btn btn-primary" href="{{ route('products.edit', $product->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('products.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Product Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $product->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $product->id }}"
                                action="{{ route('products.destroy', $product->id) }}" method="POST"
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