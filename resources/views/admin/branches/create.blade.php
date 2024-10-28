@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Branch</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('branches.index') }}">Branches</a></li>
                    <li class="breadcrumb-item active">Add Branch</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('branches.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                <select class="js-example-basic-single select2" name="company_id" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            @else
                                <input type="hidden" name="company_id" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole

                            <div class="mb-3 col-md-6">
                                <label for="name">Branch Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Branch Name" required>
                                <div class="invalid-feedback">Please provide a branch name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="country_id">Country</label>
                                <select name="country_id" id="country_id" class="js-example-basic-single select2" required onchange="Selectcountry()">
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
                            <div class="mb-3 col-md-6">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Branch Address"
                                    required>
                                <div class="invalid-feedback">Please provide an address.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" placeholder="Branch Phone"
                                    required>
                                <div class="invalid-feedback">Please provide a phone number.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email">Email (Optional)</label>
                                <input type="email" class="form-control" name="email" placeholder="Branch Email">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_name">Contact Person Name (Optional)</label>
                                <input type="text" class="form-control" name="contact_person_name"
                                    placeholder="Contact Person Name">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="contact_person_phone">Contact Person Phone (Optional)</label>
                                <input type="text" class="form-control" name="contact_person_phone"
                                    placeholder="Contact Person Phone">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('branches.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
