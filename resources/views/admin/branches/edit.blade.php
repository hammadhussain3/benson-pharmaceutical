@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Branch</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('branches.index') }}">Branches</a></li>
                    <li class="breadcrumb-item active">Edit Branch</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('branches.update', $branch->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                <select class="js-example-basic-single select2" name="company_id" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $branch->company_id == $company->id ? 'selected' : '' }}>{{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name">Branch Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Branch Name" value="{{ $branch->name }}" required>
                                <div class="invalid-feedback">Please provide a branch name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="country_id">Country</label>
                                <select name="country_id" id="country_id" class="js-example-basic-single select2" required>
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $country->id == $company->country_id ? 'selected' : '' }}>
                                            {{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a country.</div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="city_id">City</label>
                                <select name="city_id" id="city_id" class="js-example-basic-single select2" required>
                                    <option value="">Select City</option>
                                    @if (isset($company->city_id))
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ $city->id == $company->city_id ? 'selected' : '' }}>{{ $city->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">Please select a city.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Branch Address"
                                    value="{{ $branch->address }}" required>
                                <div class="invalid-feedback">Please provide an address.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" placeholder="Branch Phone"
                                    value="{{ $branch->phone }}" required>
                                <div class="invalid-feedback">Please provide a phone number.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email">Email (Optional)</label>
                                <input type="email" class="form-control" name="email" value="{{ $branch->email }}"
                                    placeholder="Branch Email">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_name">Contact Person Name (Optional)</label>
                                <input type="text" class="form-control" name="contact_person_name"
                                    value="{{ $branch->contact_person_name }}" placeholder="Contact Person Name">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_phone">Contact Person Phone (Optional)</label>
                                <input type="text" class="form-control" name="contact_person_phone"
                                    value="{{ $branch->contact_person_phone }}" placeholder="Contact Person Phone">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('branches.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
