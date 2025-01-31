@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Country Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('countries.index') }}">Countries</a></li>
                    <li class="breadcrumb-item active">Country Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        <div class="mb-3 col-md-6">
                            <label for="name">Country Name</label>
                            <input type="text" class="form-control" value="{{ $country->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="currency">Currency</label>
                            <input type="text" class="form-control" value="{{ $country->currency ?? 'N/A' }}" readonly>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('countries.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection
