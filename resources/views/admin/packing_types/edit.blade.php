@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Packing Type</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('packingtypes.index') }}">Packing Types</a></li>
                    <li class="breadcrumb-item active">Edit Packing Type</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('packingtypes.update', $packingTypes->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                <select class="js-example-basic-single select2" name="company" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company', $packingTypes->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ $packingTypes->company_id }}">
                            @endrole
                            <div class="mb-3 col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Name" value="{{ old('name', $packingTypes->name) }}" required>
                                <div class="invalid-feedback">Please provide a name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone">Description</label>
                                <input type="text" class="form-control" name="description" placeholder="Description"
                                    value="{{ old('description', $packingTypes->description) }}" required>
                                <div class="invalid-feedback">Please provide a Description.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('packingtypes.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
