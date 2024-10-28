@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Company</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Companies</a></li>
                    <li class="breadcrumb-item active">Add Company</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('companies.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            <div class="mb-3 col-md-12">
                                <label for="name">Company Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Company Name" value="{{ old('name') }}" required>
                                <div class="invalid-feedback">Please provide a valid company name.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" id="address"
                                    placeholder="Address" value="{{ old('address') }}" required>
                                <div class="invalid-feedback">Please provide a valid address.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="country_id">Country</label>
                                <select name="country_id" id="country_id" class="js-example-basic-single select2" required onchange="Selectcountry(this.value)">
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
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone"
                                    value="{{ old('phone') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                    value="{{ old('email') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="website">Website</label>
                                <input type="url" class="form-control" name="website" id="website"
                                    placeholder="Website" value="{{ old('website') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="ntn">NTN</label>
                                <input type="text" class="form-control" name="ntn" id="ntn"
                                    placeholder="National Tax Number" value="{{ old('ntn') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="strn">STRN</label>
                                <input type="text" class="form-control" name="strn" id="strn"
                                    placeholder="Sales Tax Registration Number" value="{{ old('strn') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="is_active">Is Active</label>
                                <select name="is_active" id="is_active" class="form-control">
                                    <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="logo_path">Logo Path</label>
                                <input type="text" class="form-control" name="logo_path" id="logo_path"
                                    placeholder="Logo Path" value="{{ old('logo_path') }}">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('companies.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
