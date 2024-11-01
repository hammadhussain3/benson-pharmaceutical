@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Party</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('parties.index') }}">Parties</a></li>
                    <li class="breadcrumb-item active">Add Party</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('parties.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="name">Party Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Party Name" required value="{{ old('name') }}">
                                <div class="invalid-feedback">Please provide a valid party name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="code">Party Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                    placeholder="Party Code" required value="{{ old('code') }}">
                                <div class="invalid-feedback">Please provide a valid party code.</div>
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
                                    @foreach ($cities as $city)
                                        <!-- Assuming you pass cities based on old country -->
                                        <option value="{{ $city->id }}"
                                            {{ old('city') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a city.</div>
                            </div>
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company">Company</label>
                                <select name="company" id="company" class="js-example-basic-single select2" required>
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
                                <input type="hidden" name="company_id" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_name">Contact Person Name</label>
                                <input type="text" class="form-control" name="contact_person_name"
                                    id="contact_person_name" placeholder="Contact Person Name" value="{{ old('contact_person_name') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_phone">Contact Person Phone</label>
                                <input type="text" class="form-control" name="contact_person_phone"
                                    id="contact_person_phone" placeholder="+123 1234567890" value="{{ old('contact_person_phone') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_email">Contact Person Email</label>
                                <input type="email" class="form-control" name="contact_person_email"
                                    id="contact_person_email" placeholder="Contact Person Email" value="{{ old('contact_person_email') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="+123 1234567890"
                                    required value="{{ old('phone') }}">
                                <div class="invalid-feedback">Please provide a valid phone number.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                    required value="{{ old('email') }}">
                                <div class="invalid-feedback">Please provide a valid email address.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address">Address</label>
                                <textarea class="form-control" name="address" id="address" placeholder="Address">{{ old('address') }}</textarea>
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

                            <div class="mb-3 col-md-6">
                                <label for="is_supplier">Is Supplier?</label>
                                <select name="is_supplier" id="is_supplier" class="form-control" required>
                                    <option value="0" {{ old('is_supplier') == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('is_supplier') == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="is_distributor">Is Distributor?</label>
                                <select name="is_distributor" id="is_distributor" class="form-control" required>
                                    <option value="0" {{ old('is_distributor') == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('is_distributor') == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('parties.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
