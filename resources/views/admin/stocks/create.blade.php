@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Stock</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('stocks.index') }}">Stocks</a></li>
                    <li class="breadcrumb-item active">Add Stock</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('stocks.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company">Company</label>
                                <select name="company" id="company" class="js-example-basic-single select2" required @role('Superadmin') onchange="selectProducts(this.value); selectRawMaterialItems(this.value);" @endrole>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company') == $company->id ? 'selected' : '' }}>
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
                                    @if(old('product') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                        @php
                                            $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($products->where('company_id', $seletedCompanyId) as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="raw_material_item_id">Raw Material</label>
                                <select name="raw_material_item" id="raw_material_item_id" class="form-control" required>
                                    <option value="">Select Raw Material</option>
                                    @if(old('raw_material_item') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                        @php
                                            $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($rawMaterialItems->where('company_id', $seletedCompanyId) as $rawMaterialItem)
                                            <option value="{{ $rawMaterialItem->id }}"
                                                {{ old('raw_material_item') == $rawMaterialItem->id ? 'selected' : '' }}>
                                                {{ $rawMaterialItem->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="available_quantity">Available Quantity</label>
                                <input type="number" class="form-control" name="available_quantity" id="available_quantity" min="0"
                                    placeholder="Available Quantity" required value="{{ old('available_quantity') }}" oninput="calculateValue()">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control" name="unit" id="unit"
                                    placeholder="Unit" required value="{{ old('unit') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="rate">Rate</label>
                                <input type="number" class="form-control" name="rate" id="rate" min="0"
                                    placeholder="Rate" required value="{{ old('rate') }}" oninput="calculateValue()">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="value">Value</label>
                                <input type="number" class="form-control" name="value" id="value" min="0"
                                    placeholder="Value" required value="{{ old('value') }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="min_level">Min. Level</label>
                                <input type="number" class="form-control" name="min_level" id="min_level" min="0"
                                    placeholder="Min. Level" required value="{{ old('min_level') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="max_level">Max. Level</label>
                                <input type="number" class="form-control" name="max_level" id="max_level" min="0"
                                    placeholder="Max. Level" required value="{{ old('max_level') }}">
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