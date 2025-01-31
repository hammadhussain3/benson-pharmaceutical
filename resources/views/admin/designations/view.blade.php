@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Designation Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('designations.index') }}">Designations</a></li>
                    <li class="breadcrumb-item active">Designation Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        <div class="mb-3 col-md-12">
                            <label for="name">Designation Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $designations->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Company Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $designations->company->name }}" readonly>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('designations.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection