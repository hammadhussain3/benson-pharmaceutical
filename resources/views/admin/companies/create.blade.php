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
                    <form action="{{ route('companies.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
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
                                <select name="country" id="country_id" class="js-example-basic-single select2" required onchange="Selectcountry(this.value)">
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
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="+123 1234567890"
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
                                    placeholder="https://example.com" value="{{ old('website') }}">
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
                                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="logo_path">Logo</label>
                                <input type="file" class="form-control" name="logo" id="logo_path"
                                    placeholder="Logo" value="{{ old('logo') }}">
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
