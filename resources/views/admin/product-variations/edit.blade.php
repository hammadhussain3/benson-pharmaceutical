@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Product Variation</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('product-variations.index') }}">Product Variations</a></li>
                    <li class="breadcrumb-item active">Edit Product Variation</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product-variations.update', $productVariation->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company">Company</label>
                                <select name="company" id="company" class="js-example-basic-single select2" required @role('Superadmin') onchange="selectProducts(this.value); selectDosageForms(this.value); selectPackForms(this.value); selectPackSizes(this.value); selectPackingTypes(this.value);" @endrole>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company', $productVariation->company_id) == $company->id ? 'selected' : '' }}>
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
                                        $selectedCompanyId = old('company', $productVariation->company_id);
                                    @endphp
                                    @foreach ($products->where('company_id', $selectedCompanyId) as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $product->id == old('product', $productVariation->product_id) ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="dosage_form_id">Dosage Form</label>
                                <select name="dosage_form" id="dosage_form_id" class="form-control" required>
                                    <option value="">Select Dosage Form</option>
                                    @php
                                        $selectedCompanyId = old('company', $productVariation->company_id);
                                    @endphp
                                    @foreach ($dosage_forms->where('company_id', $selectedCompanyId) as $dosage_form)
                                        <option value="{{ $dosage_form->id }}"
                                            {{ $dosage_form->id == old('dosage_form', $productVariation->dosage_form_id) ? 'selected' : '' }}>
                                            {{ $dosage_form->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="pack_form_id">Pack Form</label>
                                <select name="pack_form" id="pack_form_id" class="form-control" required>
                                    <option value="">Select Pack Form</option>
                                    @php
                                        $selectedCompanyId = old('company', $productVariation->company_id);
                                    @endphp
                                    @foreach ($pack_forms->where('company_id', $selectedCompanyId) as $pack_form)
                                        <option value="{{ $pack_form->id }}"
                                            {{ $pack_form->id == old('pack_form', $productVariation->pack_form_id) ? 'selected' : '' }}>
                                            {{ $pack_form->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="pack_size_id">Pack Size</label>
                                <select name="pack_size" id="pack_size_id" class="form-control" required>
                                    <option value="">Select Pack Size</option>
                                    @php
                                        $selectedCompanyId = old('company', $productVariation->company_id);
                                    @endphp
                                    @foreach ($pack_sizes->where('company_id', $selectedCompanyId) as $pack_size)
                                        <option value="{{ $pack_size->id }}"
                                            {{ $pack_size->id == old('pack_size', $productVariation->pack_size_id) ? 'selected' : '' }}>
                                            {{ $pack_size->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="packing_type_id">Packing Type</label>
                                <select name="packing_type" id="packing_type_id" class="form-control" required>
                                    <option value="">Select Packing Type</option>
                                    @php
                                        $selectedCompanyId = old('company', $productVariation->company_id);
                                    @endphp
                                    @foreach ($packing_types->where('company_id', $selectedCompanyId) as $packing_type)
                                        <option value="{{ $packing_type->id }}"
                                            {{ $packing_type->id == old('packing_type', $productVariation->packing_type_id) ? 'selected' : '' }}>
                                            {{ $packing_type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="trade_price">Trade Price</label>
                                <input type="number" class="form-control" name="trade_price" id="trade_price" min="0"
                                    placeholder="Trade Price" required value="{{ old('trade_price', $productVariation->trade_price) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="our_mrp">Our MRP</label>
                                <input type="number" class="form-control" name="our_mrp" id="our_mrp" min="0"
                                    placeholder="Our MRP" required value="{{ old('our_mrp', $productVariation->our_mrp) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="drap_mrp">Drap MRP</label>
                                <input type="number" class="form-control" name="drap_mrp" id="drap_mrp" min="0"
                                    placeholder="Drap MRP" required value="{{ old('drap_mrp', $productVariation->drap_mrp) }}">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('product-variations.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection