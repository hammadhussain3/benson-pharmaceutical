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
                                <select name="company" id="company" class="js-example-basic-single select2" required @role('Superadmin') onchange="selectProductsAndRawMaterials(this.value);" @endrole>
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
                                <select name="product" class="js-example-basic-single select2 products_dropdown" required>
                                    <option value="">Select Product or Raw Material</option>
                                    @php
                                        $seletedCompanyId = old('company', $stock->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    <optgroup label="Products">
                                        @foreach ($products->where('company_id', $seletedCompanyId) as $product)
                                            <option value="{{ 'product_' .$product->id }}"
                                                {{ old('product', 'product_' .$stock->product_id) == 'product_' .$product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Raw Materials">
                                        @foreach ($rawMaterialItems->where('company_id', $seletedCompanyId) as $rawMaterialItem)
                                            <option value="{{ 'raw_' .$rawMaterialItem->id }}"
                                                {{ old('product', 'raw_' .$stock->raw_material_item_id) == 'raw_' .$rawMaterialItem->id ? 'selected' : '' }}>
                                                {{ $rawMaterialItem->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" name="quantity" id="quantity" min="0"
                                    placeholder="Quantity" required value="{{ old('quantity', $stock->quantity) }}" oninput="calculateValue()">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="unit_price">Unit Price</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="unit_price" id="unit_price" min="0"
                                        placeholder="Unit Price" required value="{{ old('unit_price', $stock->unit_price) }}" oninput="calculateValue()">
                                    <input type="text" class="form-control" name="unit" id="unit"
                                        placeholder="Unit" required value="{{ old('unit', $stock->unit) }}">
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="total">Total</label>
                                <input type="number" class="form-control" name="total" id="total" min="0"
                                    placeholder="Value" required value="{{ old('total', $stock->total) }}" readonly>
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