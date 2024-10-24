@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Payment Type</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('payment_types.index') }}">Payment Types</a></li>
                    <li class="breadcrumb-item active">Edit Payment Type</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('payment_types.update', $paymentType->id) }}" method="POST"
                        class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-12">
                                <label for="name">Payment Type Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $paymentType->name }}" required>
                                <div class="invalid-feedback">Please provide a valid payment type name.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Description">{{ $paymentType->description }}</textarea>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="company">Company</label>
                                <select name="company_id" id="company" class="js-example-basic-single select2" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $company->id == $paymentType->company_id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('payment_types.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
