@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Tax</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('taxes.index') }}">Taxes</a></li>
                    <li class="breadcrumb-item active">Edit Tax</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('taxes.update', $tax->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $tax->name) }}" placeholder="Tax Name" required>
                                <div class="invalid-feedback">Please provide a valid tax name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="rate">Rate</label>
                                <input type="text" class="form-control" name="rate" id="rate"
                                    value="{{ old('rate', $tax->rate) }}" placeholder="Tax Rate" required>
                                <div class="invalid-feedback">Please provide a valid tax rate.</div>
                            </div>
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company_id">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $company->id == old('company', $tax->company_id) ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ $tax->company_id }}">
                            @endrole
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('taxes.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection