@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Company</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Companies</a></li>
                    <li class="breadcrumb-item active">Edit Company</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('companies.update', $company->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-12">
                                <label for="name">Company Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $company->name) }}" placeholder="Company Name" required>
                                <div class="invalid-feedback">Please provide a valid company name.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" id="address"
                                    value="{{ old('address', $company->address) }}" placeholder="Address" required>
                                <div class="invalid-feedback">Please provide a valid address.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="country_id">Country</label>
                                <select name="country" id="country_id" class="js-example-basic-single select2" required onchange="Selectcountry(this.value)">
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
                                <select name="city" id="city_id" class="js-example-basic-single select2" required>
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
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                    value="{{ old('phone', $company->phone) }}" placeholder="Phone">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ old('email', $company->email) }}" placeholder="Email">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="website">Website</label>
                                <input type="url" class="form-control" name="website" id="website"
                                    value="{{ old('website', $company->website) }}" placeholder="Website">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="ntn">NTN</label>
                                <input type="text" class="form-control" name="ntn" id="ntn"
                                    value="{{ old('ntn', $company->ntn) }}" placeholder="National Tax Number">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="strn">STRN</label>
                                <input type="text" class="form-control" name="strn" id="strn"
                                    value="{{ old('strn', $company->strn) }}" placeholder="Sales Tax Registration Number">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="is_active">Is Active</label>
                                <select name="is_active" id="is_active" class="form-control">
                                    <option value="1" {{ $company->is_active ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ !$company->is_active ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="logo_path">Logo</label>
                                <input type="file" class="form-control" name="logo" id="logo_path"
                                    value="{{ old('logo_path', $company->logo_path) }}" placeholder="Logo Path">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('companies.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('country_id').addEventListener('change', function() {
            var countryId = this.value;
            var citySelect = document.getElementById('city_id');
            citySelect.innerHTML = '<option value="">Select City</option>'; // Reset cities

            if (countryId) {
                fetch(`/countries/${countryId}/cities`)
                    .then(response => response.json())
                    .then(data => {
                        data.cities.forEach(function(city) {
                            var option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching cities:', error));
            }
        });
    </script>
@endsection
