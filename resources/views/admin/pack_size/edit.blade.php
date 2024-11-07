@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Pack Size</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Pack Size</a></li>
                    <li class="breadcrumb-item active">Edit Pack Size</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('pack_size.update', $pack_size->id) }}" method="POST" class="needs-validation"
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
                                            {{ old('company', $pack_size->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ $pack_size->company_id }}">
                            @endrole
                            <div class="mb-3 col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Name" value="{{ old('name', $pack_size->name) }}" required>
                                <div class="invalid-feedback">Please provide a name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone">Description</label>
                                <input type="text" class="form-control" name="description" placeholder="Description"
                                    value="{{ old('description', $pack_size->description) }}" required>
                                <div class="invalid-feedback">Please provide a Description.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('pack_size.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
