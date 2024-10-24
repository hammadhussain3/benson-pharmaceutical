@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit City</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('cities.index') }}">Cities</a></li>
                    <li class="breadcrumb-item active">Edit City</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('cities.update', $city->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-12">
                                <label for="name">City Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $city->name }}" required>
                                <div class="invalid-feedback">Please provide a valid city name.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="country_id">Country</label>
                                <select class="js-example-basic-single select2" name="country_id" id="country_id" required>
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $country->id == $city->country_id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a country.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('cities.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
