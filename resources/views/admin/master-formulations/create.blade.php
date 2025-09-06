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
                            

                            <div class="mf-item-set">
                                <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Master Formulation</h4>
                                </div>
                                <div class="card-body px-0 pb-0">
                                    <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="raw_material_item_id">Raw Material Items<span class="text-danger">*</span></label>
                                        <select class="js-example-basic-single select2" name="raw_material_item_id" id="raw_material_item_id" required>
                                            <option value="">Select Raw Material</option>
                                            @foreach ($rawMaterialItems as $rawMaterialItem)
                                                <option value="{{ $rawMaterialItem->id }}" {{ old('raw_material_item_id') == $rawMaterialItem->id ? 'selected' : '' }}>{{ $rawMaterialItem->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('raw_material_item_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="code">Code<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="code" id="code"
                                            placeholder="Code" required value="{{ old('code') }}" readonly>
                                        @error('code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="unit">Unit<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="unit" id="unit"
                                            placeholder="unit" required value="{{ old('unit') }}" readonly>
                                        @error('unit')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    </div>
                                </div>
                            </div>

                            

                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('master-formulations.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#raw_material_item_id').on('change', function(){
            let itemId = $(this).val();
            if(itemId){
                $.ajax({
                    url: '/raw-material-items/' + itemId + '/data',
                    type: 'GET',
                    success: function(response){
                        if(response.code){
                            $('#code').val(response.code);
                            $('#unit').val(response.unit);
                        }
                    },
                    error: function(){
                        alert('Error fetching code');
                    }
                });
            }
        });

    </script>
        

@endsection