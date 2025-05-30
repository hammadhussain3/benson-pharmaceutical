@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit New Sub Chart of Account</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sub_chart_of_accounts.index') }}">Chart of Accounts</a></li>
                    <li class="breadcrumb-item active">Edit Chart of Account</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sub_chart_of_accounts.update', $subChartOfAccount) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            @role('Superadmin')
                                <div class="mb-3 col-md-12">
                                    <label for="company">Company</label>
                                    <select name="company" id="company_id" class="js-example-basic-single select2" required onchange="selectChartOfAccounts(this.value); selectCategories(this.value);">
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ old('company', $subChartOfAccount->company_id) == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a company.</div>
                                </div>
                            @else
                                <input type="hidden" name="company" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                            <div class="mb-3 col-md-6">
                                <label for="type">Chart of Accounts</label>
                                <select class="js-example-basic-single select2" name="chart_of_account" id="chart_of_account_id" required>
                                    <option value="">Select Chart Of Account</option>
                                    @php
                                        $seletedCompanyId = old('company', $subChartOfAccount->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($chartOfAccounts->where('company_id', $seletedCompanyId) as $chartOfAccount)
                                        <option value="{{ $chartOfAccount->id }}"
                                            {{ old('chart_of_account', $subChartOfAccount->chart_of_account_id) == $chartOfAccount->id ? 'selected' : '' }}>
                                            {{ $chartOfAccount->particular }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name Or Description"
                                    required value="{{ old('name', $subChartOfAccount->name) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="category">Category</label>
                                <select name="category" id="category_id" class="js-example-basic-single select2" required onchange="selectCategoryPrefix(this.value); selectSubCategory(this.value);">
                                    <option value="">Select Category</option>
                                    @php
                                        $seletedCompanyId = old('company', $subChartOfAccount->company_id) ?? auth()->user()->employee->company_id;
                                    @endphp
                                    @foreach ($categories->where('company_id', $seletedCompanyId) as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category', $subChartOfAccount->category->id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('sub_chart_of_accounts.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection