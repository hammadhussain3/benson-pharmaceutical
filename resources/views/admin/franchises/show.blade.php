@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Customer Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('franchises.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active">Customer Details</li>
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
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $franchise->company->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $franchise->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Code</label>
                            <input type="text" class="form-control" value="{{ $franchise->code ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Category</label>
                            <input type="text" class="form-control" value="{{ $franchise->category->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Sub-Category</label>
                            <input type="text" class="form-control" value="{{ optional($franchise->subCategory)->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Chart Of Account</label>
                            <input type="text" class="form-control" value="{{ $franchise->chart_of_account->particular ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Sub Chart Of Account</label>
                            <input type="text" class="form-control" value="{{ optional($franchise->sub_chart_of_account)->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Country</label>
                            <input type="text" class="form-control" value="{{ $franchise->country->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>City</label>
                            <input type="text" class="form-control" value="{{ $franchise->city->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Contact Person Name</label>
                            <input type="text" class="form-control" value="{{ $franchise->contact_person_name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Contact Person Email</label>
                            <input type="text" class="form-control" value="{{ $franchise->contact_person_email ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Contact Person Phone</label>
                            <input type="text" class="form-control" value="{{ $franchise->contact_person_phone ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ $franchise->email ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Phone</label>
                            <input type="text" class="form-control" value="{{ $franchise->phone ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Address</label>
                            <input type="text" class="form-control" value="{{ $franchise->address ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Payment Type</label>
                            <input type="text" class="form-control" value="{{ $franchise->paymentType->name ?? 'N/A' }}" readonly>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('franchises.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection