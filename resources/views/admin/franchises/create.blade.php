@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Customer</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('franchises.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active">Add Customer</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('franchises.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            @role('Superadmin')
                                <div class="mb-3 col-md-12">
                                    <label for="company">Company</label>
                                    <select name="company" id="company" class="js-example-basic-single select2" required @role('Superadmin') onchange="createFranchiseCode(this.value); selectCategories(this.value); selectChartOfAccounts(this.value);" @endrole>
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ old('company') == $company->id ? 'selected' : '' }}>
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
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Name" required value="{{ old('name') }}">
                                <div class="invalid-feedback">Please provide a valid franchise name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="code">Code</label>
                                <div class="input-group">
                                    <input type="text" name="category_prefix" id="category_prefix" class="form-control" value="{{ old('category_prefix') }}" readonly>
                                    <input type="text" name="sub_category_prefix" id="sub_category_prefix" class="form-control" value="{{ old('sub_category_prefix') }}" readonly>
                                    <input type="text" class="form-control" name="code" id="code" style="width: 165px;"
                                        placeholder="Code" required value="{{ old('code', $newFranchiseCode) }}" readonly>
                                </div>
                            </div>
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
                                <label for="type">Chart of Accounts</label>
                                <select class="js-example-basic-single select2" name="chart_of_account" id="chart_of_account_id" required onchange="selectSubChartOfAccounts(this.value);">
                                    <option value="">Select Chart Of Account</option>
                                    @if(old('chart_of_account') || old('company') || !auth()->user()->hasRole('Superadmin'))
                                        @php
                                            $seletedCompanyId = old('company') ?? auth()->user()->employee->company_id;
                                        @endphp
                                        @foreach ($chartOfAccounts->where('company_id', $seletedCompanyId) as $chartOfAccount)
                                            <option value="{{ $chartOfAccount->id }}"
                                                {{ old('chart_of_account') == $chartOfAccount->id ? 'selected' : '' }}>
                                                {{ $chartOfAccount->particular }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="sub_chart_of_account">Sub Chart of Accounts</label>
                                <select class="js-example-basic-single select2" name="sub_chart_of_account" id="sub_chart_of_account_id" required>
                                    <option value="">Select Sub Chart Of Account</option>
                                    @if(old('sub_chart_of_account') || old('chart_of_account'))
                                        @php
                                            $seletedChartOfAccountId = old('chart_of_account');
                                        @endphp
                                        @foreach ($subChartOfAccounts->where('chart_of_account_id', $seletedChartOfAccountId) as $subChartOfAccount)
                                            <option value="{{ $subChartOfAccount->id }}"
                                                {{ old('sub_chart_of_account') == $subChartOfAccount->id ? 'selected' : '' }}>
                                                {{ $subChartOfAccount->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="country_id">Country</label>
                                <select name="country" id="country_id" class="js-example-basic-single select2" required onchange="Selectcountry()">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a country.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="city_id">City</label>
                                <select name="city" id="city_id" class="js-example-basic-single select2" required>
                                    <option value="">Select City</option>
                                    @if(old('city') || old('country'))
                                        @foreach ($cities->where('country_id', old('country')) as $city)
                                            <option value="{{ $city->id }}"
                                                {{ old('city') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">Please select a city.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_name">Contact Person Name</label>
                                <input type="text" class="form-control" name="contact_person_name"
                                    id="contact_person_name" placeholder="Contact Person Name" value="{{ old('contact_person_name') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_email">Contact Person Email</label>
                                <input type="email" class="form-control" name="contact_person_email"
                                    id="contact_person_email" placeholder="Contact Person Email" value="{{ old('contact_person_email') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_phone">Contact Person Phone</label>
                                <input type="text" class="form-control" name="contact_person_phone"
                                    id="contact_person_phone" placeholder="+123 1234567890" value="{{ old('contact_person_phone') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                    required value="{{ old('email') }}">
                                <div class="invalid-feedback">Please provide a valid email address.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="+123 1234567890"
                                    required value="{{ old('phone') }}">
                                <div class="invalid-feedback">Please provide a valid phone number.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}" placeholder="Complete Address">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="payment_type_id">Payment Type</label>
                                <select name="payment_type" id="payment_type_id" class="form-control" required>
                                    <option value="">Select Payment Type</option>
                                    @foreach ($paymentTypes as $paymentType)
                                        <option value="{{ $paymentType->id }}"
                                            {{ old('payment_type') == $paymentType->id ? 'selected' : '' }}>
                                            {{ $paymentType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a payment type.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('franchises.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection