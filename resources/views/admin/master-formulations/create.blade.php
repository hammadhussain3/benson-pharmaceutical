@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Master Formulation</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('master-formulations.index') }}">Master Formulations</a></li>
                    <li class="breadcrumb-item active">Add Master Formulation</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('master-formulations.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="brand_name">Brand<span class="text-danger">*</span></label>
                                <select class="js-example-basic-single select2" name="brand_name" id="brand_name" required>
                                    <option value="">Select Brand</option>
                                    @foreach ($brandNames as $brand)
                                        <option value="{{ $brand }}" {{ old('brand_name') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                    @endforeach
                                </select>
                                @error('brand_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="product_name">Product (manual)<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="product_name" id="product_name"
                                    placeholder="Enter product name" required value="{{ old('product_name') }}">
                                @error('product_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="batch_size">Batch Size<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="batch_size" id="batch_size"
                                    placeholder="Batch Size" required value="{{ old('batch_size') }}" step="0.01" min="0.01">
                                @error('batch_size')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('master-formulations.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection