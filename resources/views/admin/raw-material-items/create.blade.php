@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Raw Material Item</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('raw-material-items.index') }}">Raw Material Items</a></li>
                    <li class="breadcrumb-item active">Add Raw Material Item</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('raw-material-items.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            @role('Superadmin')
                                <div class="mb-3 col-md-12">
                                    <label for="company">Company</label>
                                    <select name="company" id="company" class="js-example-basic-single select2" required @role('Superadmin') onchange="createRawMaterialItemCode(this.value); selectSuppliers(this.value); selectCategories(this.value)" @endrole>
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
                                <label for="category">Category</label>
                                <select name="category" id="category_id" class="js-example-basic-single select2" required onchange="selectCategoryPrefix(this.value); selectSubCategory(this.value);">
                                    <option value="">Select Category</option>
                                    @if(old('category') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                        @php
                                            $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($categories->where('company_id', $seletedCompanyId) as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="sub_category">Sub Category</label>
                                <select name="sub_category" id="sub_category" class="js-example-basic-single select2" required onchange="selectSubCategoryPrefix(this.value);">
                                    <option value="">Select Sub Category</option>
                                    @if(old('sub_category') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                        @php
                                            $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($subCategories->where('company_id', $seletedCompanyId) as $subCategory)
                                            <option value="{{ $subCategory->id }}"
                                                {{ old('sub_category') == $subCategory->id ? 'selected' : '' }}>
                                                {{ $subCategory->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="code">Code</label>
                                <div class="input-group">
                                    <input type="text" name="category_prefix" id="category_prefix" class="form-control" value="{{ old('category_prefix') }}" readonly>
                                    <input type="text" name="sub_category_prefix" id="sub_category_prefix" class="form-control" value="{{ old('sub_category_prefix') }}" readonly>
                                    <input type="text" class="form-control" name="code" id="code" style="width: 165px;"
                                        placeholder="Code" required value="{{ old('code', $newRawMaterialItemCode) }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Name" required value="{{ old('name') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control" name="unit" id="unit"
                                    placeholder="Unit" required value="{{ old('unit') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="supplier_id">Supplier</label>
                                <select name="party" id="supplier_id" class="form-control" required>
                                    <option value="">Select Supplier</option>
                                    @if(old('party') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                        @php
                                            $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($parties->where('company_id', $seletedCompanyId) as $party)
                                            <option value="{{ $party->id }}"
                                                {{ old('party') == $party->id ? 'selected' : '' }}>
                                                {{ $party->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="min_level">Min Level</label>
                                <input type="text" class="form-control" name="min_level" id="min_level"
                                    placeholder="Min Level" required value="{{ old('min_level') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="max_level">Max Level</label>
                                <input type="text" class="form-control" name="max_level" id="max_level"
                                    placeholder="Max Level" required value="{{ old('max_level') }}">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label>Description</label>
                                <textarea class="form-control" name="description" id="description"
                                    placeholder="Description..." maxlength="1000">{{ old("description") }}</textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('raw-material-items.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection