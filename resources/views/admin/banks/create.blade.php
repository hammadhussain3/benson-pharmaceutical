@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Bank</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('banks.index') }}">Banks</a></li>
                    <li class="breadcrumb-item active">Add Bank</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('banks.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            <div class="mb-3 col-md-12">
                                <label for="name">Bank Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Bank Name" required>
                                <div class="invalid-feedback">Please provide a valid bank name.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="acronym">Acronym</label>
                                <input type="text" class="form-control" name="acronym" id="acronym"
                                    placeholder="Acronym" required>
                                <div class="invalid-feedback">Please provide a valid acronym.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="country_id">Country</label>
                                <select name="country" id="country_id" class="js-example-basic-single select2" required>
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a country.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('banks.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
