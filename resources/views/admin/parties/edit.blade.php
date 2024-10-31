@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Party</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('parties.index') }}">Parties</a></li>
                    <li class="breadcrumb-item active">Edit Party</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('parties.update', $party->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="name">Party Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $party->name) }}" placeholder="Party Name" required>
                                <div class="invalid-feedback">Please provide a valid party name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="code">Party Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                    value="{{ old('code', $party->code) }}" placeholder="Party Code" required>
                                <div class="invalid-feedback">Please provide a valid party code.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="country_id">Country</label>
                                <select name="country" id="country_id" class="js-example-basic-single select2" required onchange="Selectcountry()">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $country->id == old('country', $party->country_id) ? 'selected' : '' }}>
                                            {{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a country.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="city_id">City</label>
                                <select name="city" id="city_id" class="js-example-basic-single select2" required>
                                    <option value="">Select City</option>
                                    @if (isset($party->city_id))
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ $city->id == old('city', $party->city_id) ? 'selected' : '' }}>{{ $city->name }}
                                            </option>
                                        @endforeach
                                    @endif
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
                                            {{ $company->id == old('company', $party->company_id) ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            @else
                                <input type="hidden" name="company_id" value="{{ $party->company_id }}">
                            @endrole
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_name">Contact Person Name</label>
                                <input type="text" class="form-control" name="contact_person_name"
                                    id="contact_person_name" value="{{ old('contact_person_name', $party->contact_person_name) }}"
                                    placeholder="Contact Person Name">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_phone">Contact Person Phone</label>
                                <input type="text" class="form-control" name="contact_person_phone"
                                    id="contact_person_phone" value="{{ old('contact_person_phone', $party->contact_person_phone) }}"
                                    placeholder="Contact Person Phone">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_email">Contact Person Email</label>
                                <input type="email" class="form-control" name="contact_person_email"
                                    id="contact_person_email" value="{{ old('contact_person_email', $party->contact_person_email) }}"
                                    placeholder="Contact Person Email">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                    value="{{ old('phone', $party->phone) }}" placeholder="Phone" required>
                                <div class="invalid-feedback">Please provide a valid phone number.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ old('email', $party->email) }}" placeholder="Email" required>
                                <div class="invalid-feedback">Please provide a valid email address.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address">Address</label>
                                <textarea class="form-control" name="address" id="address" placeholder="Address">{{ old('address', $party->address) }}</textarea>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="payment_type_id">Payment Type</label>
                                <select name="payment_type" id="payment_type_id" class="form-control" required>
                                    <option value="">Select Payment Type</option>

                                    @foreach ($paymentTypes as $paymentType)
                                        <option value="{{ $paymentType->id }}"
                                            {{ old('payment_type_id', $party->payment_type_id) == $paymentType->id ? 'selected' : '' }}>
                                            {{ $paymentType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a payment type.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="is_supplier">Is Supplier?</label>
                                <select name="is_supplier" id="is_supplier" class="form-control" required>
                                    <option value="0" {{ old('is_supplier', $party->is_supplier) == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('is_supplier', $party->is_supplier) == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="is_distributor">Is Distributor?</label>
                                <select name="is_distributor" id="is_distributor" class="form-control" required>
                                    <option value="0" {{ old('is_distributor', $party->is_distributor) == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('is_distributor', $party->is_distributor) == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('parties.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
