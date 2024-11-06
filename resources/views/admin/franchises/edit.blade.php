@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Franchise</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('franchises.index') }}">Franchises</a></li>
                    <li class="breadcrumb-item active">Edit Franchise</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('franchises.update', $franchise->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="name">Franchise Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $franchise->name) }}" placeholder="Franchise Name" required>
                                <div class="invalid-feedback">Please provide a valid franchise name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="code">Franchise Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                    value="{{ old('code', $franchise->code) }}" placeholder="Franchise Code" required>
                                <div class="invalid-feedback">Please provide a valid franchise code.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="country_id">Country</label>
                                <select name="country" id="country_id" class="js-example-basic-single select2" required onchange="Selectcountry()">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $country->id == old('country', $franchise->country_id) ? 'selected' : '' }}>
                                            {{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a country.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="city_id">City</label>
                                <select name="city" id="city_id" class="js-example-basic-single select2" required>
                                    <option value="">Select City</option>
                                    @php
                                        $selectedCountryId = old('country', $franchise->country_id);
                                    @endphp
                                    @foreach ($cities->where('country_id', $selectedCountryId) as $city)
                                        <option value="{{ $city->id }}"
                                            {{ $city->id == old('city', $franchise->city_id) ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a city.</div>
                            </div>
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company_id">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $company->id == old('company', $franchise->company_id) ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ $franchise->company_id }}">
                            @endrole
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_name">Contact Person Name</label>
                                <input type="text" class="form-control" name="contact_person_name"
                                    id="contact_person_name" value="{{ old('contact_person_name', $franchise->contact_person_name) }}"
                                    placeholder="Contact Person Name">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_phone">Contact Person Phone</label>
                                <input type="text" class="form-control" name="contact_person_phone"
                                    id="contact_person_phone" value="{{ old('contact_person_phone', $franchise->contact_person_phone) }}"
                                    placeholder="+123 1234567890">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_email">Contact Person Email</label>
                                <input type="email" class="form-control" name="contact_person_email"
                                    id="contact_person_email" value="{{ old('contact_person_email', $franchise->contact_person_email) }}"
                                    placeholder="Contact Person Email">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" name="phone" id="phone"
                                    value="{{ old('phone', $franchise->phone) }}" placeholder="+123 1234567890" required>
                                <div class="invalid-feedback">Please provide a valid phone number.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ old('email', $franchise->email) }}" placeholder="Email" required>
                                <div class="invalid-feedback">Please provide a valid email address.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address">Address</label>
                                <textarea class="form-control" name="address" id="address" placeholder="Address">{{ old('address', $franchise->address) }}</textarea>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="payment_type_id">Payment Type</label>
                                <select name="payment_type" id="payment_type_id" class="form-control" required>
                                    <option value="">Select Payment Type</option>
                                    @foreach ($paymentTypes as $paymentType)
                                        <option value="{{ $paymentType->id }}"
                                            {{ old('payment_type_id', $franchise->payment_type_id) == $paymentType->id ? 'selected' : '' }}>
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