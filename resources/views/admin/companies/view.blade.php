@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Company Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Companies</a></li>
                    <li class="breadcrumb-item active">Company Details</li>
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
                            <label>Company Name</label>
                            <input type="text" class="form-control" value="{{ $company->name ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-12">
                            <label>Address</label>
                            <input type="text" class="form-control" value="{{ $company->address ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>Country</label>
                            <input type="text" class="form-control" value="{{ $company->country->name ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>City</label>
                            <input type="text" class="form-control" value="{{ $company->city->name ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>Phone</label>
                            <input type="text" class="form-control" value="{{ $company->phone ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ $company->email ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>Website</label>
                            <input type="text" class="form-control" value="{{ $company->website ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>NTN</label>
                            <input type="text" class="form-control" value="{{ $company->ntn ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>STRN</label>
                            <input type="text" class="form-control" value="{{ $company->strn ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>Is Active</label>
                            <input type="text" class="form-control" value="{{ $company->is_active == '1' ? 'Yes' : 'No' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="d-block">Logo</label>
                            <img src="{{ asset($company->logo_path ? 'images/company/' . $company->logo_path : 'images/company/logo.png') }}" style="height: 80px">
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('companies.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>

@endsection