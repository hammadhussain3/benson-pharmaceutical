@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Raw Material Item</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('raw-material-items.index') }}">Raw Material Items</a></li>
                    <li class="breadcrumb-item active">Edit Raw Material Item</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('raw-material-items.update', $rawMaterialItem->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            @role('Superadmin')
                                <div class="mb-3 col-md-12">
                                    <label for="company">Company</label>
                                    <select name="company" id="company" class="js-example-basic-single select2" required @role('Superadmin') onchange="selectSuppliers(this.value); selectCategories(this.value); selectChartOfAccounts(this.value);" @endrole>
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ old('company', $rawMaterialItem->company_id) == $company->id ? 'selected' : '' }}>
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
                                    @php
                                        $seletedCompanyId = old('company', $rawMaterialItem->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($categories->where('company_id', $seletedCompanyId) as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category', $rawMaterialItem->category->id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="sub_category">Sub Category</label>
                                <select name="sub_category" id="sub_category" class="js-example-basic-single select2" required onchange="selectSubCategoryPrefix(this.value);">
                                    <option value="">Select Sub Category</option>
                                    @php
                                        $seletedCategoryId = old('company', $rawMaterialItem->category->id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($subCategories->where('category_id', $seletedCategoryId) as $subCategory)
                                        <option value="{{ $subCategory->id }}"
                                            {{ old('sub_category', optional($rawMaterialItem->subCategory)->id) == $subCategory->id ? 'selected' : '' }}>
                                            {{ $subCategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="type">Chart of Accounts</label>
                                <select class="js-example-basic-single select2" name="chart_of_account" id="chart_of_account_id" required onchange="selectSubChartOfAccounts(this.value);">
                                    <option value="">Select Chart Of Account</option>
                                    @php
                                        $seletedCompanyId = old('company', $rawMaterialItem->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($chartOfAccounts->where('company_id', $seletedCompanyId) as $chartOfAccount)
                                        <option value="{{ $chartOfAccount->id }}"
                                            {{ old('chart_of_account', $rawMaterialItem->chart_of_account_id) == $chartOfAccount->id ? 'selected' : '' }}>
                                            {{ $chartOfAccount->particular }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="sub_chart_of_account">Sub Chart of Accounts</label>
                                <select class="js-example-basic-single select2" name="sub_chart_of_account" id="sub_chart_of_account_id" required>
                                    <option value="">Select Sub Chart Of Account</option>
                                    @php
                                        $seletedChartOfAccountId = old('chart_of_account', $rawMaterialItem->chart_of_account_id);
                                    @endphp
                                    @foreach ($subChartOfAccounts->where('chart_of_account_id', $seletedChartOfAccountId) as $subChartOfAccount)
                                        <option value="{{ $subChartOfAccount->id }}"
                                            {{ old('sub_chart_of_account', $rawMaterialItem->sub_chart_of_account_id) == $subChartOfAccount->id ? 'selected' : '' }}>
                                            {{ $subChartOfAccount->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="code">Code</label>
                                <div class="input-group">
                                    <input type="text" name="category_prefix" id="category_prefix" class="form-control" value="{{ old('category_prefix', $rawMaterialItem->category ? $rawMaterialItem->category->prefix . '-' : '') }}" readonly>
                                    <input type="text" name="sub_category_prefix" id="sub_category_prefix" class="form-control" value="{{ old('sub_category_prefix', $rawMaterialItem->SubCategory ? $rawMaterialItem->SubCategory->prefix . '-' : '') }}" readonly>
                                    <input type="text" class="form-control" name="code" id="code" style="width: 165px;"
                                        placeholder="Code" required value="{{ old('code', collect(explode('-', $rawMaterialItem->code))->last()) }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Name" required value="{{ old('name', $rawMaterialItem->name) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control" name="unit" id="unit"
                                    placeholder="Unit" required value="{{ old('unit', $rawMaterialItem->unit) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="supplier_id">Supplier</label>
                                <select name="party" id="supplier_id" class="form-control" required>
                                    <option value="">Select Supplier</option>
                                    @php
                                        $selectedCompanyId = old('company', $rawMaterialItem->company_id);
                                    @endphp
                                    @foreach ($parties->where('company_id', $selectedCompanyId) as $party)
                                        <option value="{{ $party->id }}"
                                            {{ $party->id == old('party', $rawMaterialItem->party_id) ? 'selected' : '' }}>
                                            {{ $party->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="min_level">Min Level</label>
                                <input type="text" class="form-control" name="min_level" id="min_level"
                                    placeholder="Min Level" required value="{{ old('min_level',$rawMaterialItem->min_level) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="max_level">Max Level</label>
                                <input type="text" class="form-control" name="max_level" id="max_level"
                                    placeholder="Max Level" required value="{{ old('max_level',$rawMaterialItem->max_level) }}">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label>Description</label>
                                <textarea class="form-control" name="description" id="description"
                                    placeholder="Description..." maxlength="1000">{{ old("description", $rawMaterialItem->description) }}</textarea>
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