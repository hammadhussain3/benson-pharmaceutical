@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Designation</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('designations.index') }}">Designations</a></li>
                    <li class="breadcrumb-item active">Add Designation</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('designations.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row">
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                <select class="js-example-basic-single select2" name="company_id" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name">Designation Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Designation Name" required>
                                <div class="invalid-feedback">Please provide a designation name.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('designations.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
