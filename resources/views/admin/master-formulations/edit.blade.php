@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Master Formulation</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('master-formulations.index') }}">Master Formulations</a></li>
                    <li class="breadcrumb-item active">Edit Master Formulation</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('master-formulations.update', $masterFormulation->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="product_id">Product<span class="text-danger">*</span></label>
                                <select class="js-example-basic-single select2" name="product" id="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ (old('product', $masterFormulation->product_id) == $product->id) ? 'selected' : '' }}>
                                            {{ $product->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="batch_size">Batch Size<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="batch_size" id="batch_size"
                                    placeholder="Batch Size" required value="{{ old('batch_size', $masterFormulation->batch_size) }}" step="0.01" min="0.01">
                                @error('batch_size')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="product_quantity">Product Quantity<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="product_quantity" id="product_quantity"
                                    placeholder="Product Quantity" required value="{{ old('product_quantity', $masterFormulation->product_quantity) }}" step="0.01" min="0.01">
                                @error('product_quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('master-formulations.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection