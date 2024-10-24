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
                                    placeholder="Party Name" required>
                                <div class="invalid-feedback">Please provide a valid party name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="code">Party Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                    placeholder="Party Code" required>
                                <div class="invalid-feedback">Please provide a valid party code.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="country_id">Country</label>
                                <select name="country_id" id="country_id" class="js-example-basic-single select2" required>
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a country.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="city_id">City</label>
                                <select name="city_id" id="city_id" class="js-example-basic-single select2" required>
                                    <option value="">Select City</option>
                                    @if (old('country_id'))
                                        @foreach ($cities as $city)
                                            <!-- Assuming you pass cities based on old country -->
                                            <option value="{{ $city->id }}"
                                                {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">Please select a city.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="company">Company</label>
                                <select name="company_id" id="company" class="js-example-basic-single select2" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_name">Contact Person Name</label>
                                <input type="text" class="form-control" name="contact_person_name"
                                    id="contact_person_name" placeholder="Contact Person Name">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_phone">Contact Person Phone</label>
                                <input type="text" class="form-control" name="contact_person_phone"
                                    id="contact_person_phone" placeholder="Contact Person Phone">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_email">Contact Person Email</label>
                                <input type="email" class="form-control" name="contact_person_email"
                                    id="contact_person_email" placeholder="Contact Person Email">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone"
                                    required>
                                <div class="invalid-feedback">Please provide a valid phone number.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                    required>
                                <div class="invalid-feedback">Please provide a valid email address.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address">Address</label>
                                <textarea class="form-control" name="address" id="address" placeholder="Address"></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="payment_type_id">Payment Type</label>
                                <select name="payment_type_id" id="payment_type_id" class="form-control" required>
                                    <option value="">Select Payment Type</option>

                                    @foreach ($paymentTypes as $paymentType)
                                        <option value="{{ $paymentType->id }}"
                                            {{ old('payment_type_id') == $paymentType->id ? 'selected' : '' }}>
                                            {{ $paymentType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a payment type.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="is_supplier">Is Supplier?</label>
                                <select name="is_supplier" id="is_supplier" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="is_distributor">Is Distributor?</label>
                                <select name="is_distributor" id="is_distributor" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
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
