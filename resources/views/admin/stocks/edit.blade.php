@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Stock</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('stocks.index') }}">Stocks</a></li>
                    <li class="breadcrumb-item active">Edit Stock</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('stocks.update', $stock->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company">Company</label>
                                <select name="company" id="company" class="js-example-basic-single select2" required @role('Superadmin') onchange="selectProducts(this.value); selectRawMaterialItems(this.value);" @endrole>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company', $stock->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                            <div class="mb-3 col-md-6">
                                <label for="product_id">Product</label>
                                <select name="product" id="product_id" class="form-control" required>
                                    <option value="">Select Product</option>
                                    @php
                                        $selectedCompanyId = old('company', $stock->company_id);
                                    @endphp
                                    @foreach ($products->where('company_id', $selectedCompanyId) as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $product->id == old('product', $stock->product_id) ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="raw_material_item_id">Raw Material</label>
                                <select name="raw_material_item" id="raw_material_item_id" class="form-control" required>
                                    <option value="">Select Raw Material</option>
                                    @php
                                        $selectedCompanyId = old('company', $stock->company_id);
                                    @endphp
                                    @foreach ($rawMaterialItems->where('company_id', $selectedCompanyId) as $rawMaterialItem)
                                        <option value="{{ $rawMaterialItem->id }}"
                                            {{ $rawMaterialItem->id == old('raw_material_item', $stock->raw_material_item_id) ? 'selected' : '' }}>
                                            {{ $rawMaterialItem->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="available_quantity">Available Quantity</label>
                                <input type="number" class="form-control" name="available_quantity" id="available_quantity" min="0"
                                    placeholder="Available Quantity" required value="{{ old('available_quantity', $stock->available_quantity) }}" oninput="calculateValue()">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control" name="unit" id="unit"
                                    placeholder="Unit" required value="{{ old('unit', $stock->unit) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="rate">Rate</label>
                                <input type="number" class="form-control" name="rate" id="rate" min="0"
                                    placeholder="Rate" required value="{{ old('rate', $stock->rate) }}" oninput="calculateValue()">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="value">Value</label>
                                <input type="number" class="form-control" name="value" id="value" min="0"
                                    placeholder="Value" required value="{{ old('value', $stock->value) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="min_level">Min. Level</label>
                                <input type="number" class="form-control" name="min_level" id="min_level" min="0"
                                    placeholder="Min. Level" required value="{{ old('min_level', $stock->min_level) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="max_level">Max. Level</label>
                                <input type="number" class="form-control" name="max_level" id="max_level" min="0"
                                    placeholder="Max. Level" required value="{{ old('max_level', $stock->max_level) }}">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('stocks.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection