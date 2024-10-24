@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Country</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('countries.index') }}">Countries</a></li>
                    <li class="breadcrumb-item active">Edit Country</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('countries.update', $country->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-12">
                                <label for="name">Country Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $country->name }}" required>
                                <div class="invalid-feedback">Please provide a valid country name.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('countries.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
