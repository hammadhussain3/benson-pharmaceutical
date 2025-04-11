@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Brand</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Brands</a></li>
                    <li class="breadcrumb-item active">Edit Brand</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            {{-- <div class="mb-3 col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Product Name" required value="{{ old('name', $product->name) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="reg_no">Registration Number</label>
                                <input type="number" class="form-control" name="reg_no" id="reg_no"
                                    placeholder="Registration Number" required value="{{ old('reg_no', $product->reg_no) }}">
                            </div> --}}
                            <div class="mb-3 col-md-6">
                                <label for="brand_name">Brand Name</label>
                                <input type="text" class="form-control" name="brand_name" id="brand_name"
                                    placeholder="Brand Name" required value="{{ old('brand_name', $product->brand_name) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="generic_name">Generic Name</label>
                                <input type="text" class="form-control" name="generic_name" id="generic_name"
                                    placeholder="Generic Name" required value="{{ old('generic_name', $product->generic_name) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="therapeutic_class">Therapeutic Class</label>
                                <input type="text" class="form-control" name="therapeutic_class" id="therapeutic_class"
                                    placeholder="Therapeutic Class" required value="{{ old('therapeutic_class', $product->therapeutic_class) }}">
                            </div>
                            {{-- <div class="mb-3 col-md-6">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                    placeholder="Code" required value="{{ old('code', $product->code) }}" readonly>
                            </div> --}}
                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required @role('Superadmin') onchange="selectProductGroups(this.value);" @endrole>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $company->id == old('company', $product->company_id) ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ $product->company_id }}">
                            @endrole
                            {{-- <div class="mb-3 col-md-6">
                                <label for="product_group">Product Group</label>
                                <select name="product_group" id="product_group_id" class="js-example-basic-single select2" required>
                                    <option value="">Select Product Group</option>
                                    @php
                                        $selectedCompanyId = old('company', $product->company_id);
                                    @endphp
                                    @foreach ($productGroups->where('company_id', $selectedCompanyId) as $productGroup)
                                        <option value="{{ $productGroup->id }}"
                                            {{ old('product_group', $product->product_group_id) == $productGroup->id ? 'selected' : '' }}>
                                            {{ $productGroup->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('products.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection