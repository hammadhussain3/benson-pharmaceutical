@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Bank Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('banks.index') }}">Banks</a></li>
                    <li class="breadcrumb-item active">Bank Details</li>
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
                            <label for="name">Bank Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $bank->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Bank Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $bank->acronym ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Bank Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $bank->country->name ?? 'N/A' }}" readonly>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('banks.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection