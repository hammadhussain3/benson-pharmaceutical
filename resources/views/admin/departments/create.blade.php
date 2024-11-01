@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Department</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
                    <li class="breadcrumb-item active">Add Department</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('departments.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            <div class="mb-3 col-md-12">
                                <label for="name">Department Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Department Name" required value="{{ old('name') }}">
                                <div class="invalid-feedback">Please provide a valid department name.</div>
                            </div>
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" onchange="selectBranches(this.value)" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company') == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                            <div class="mb-3 col-md-12">
                                <label for="branch">Branch</label>
                                <select id="branch_id" name="branch" class="js-example-basic-single select2">
                                    <option value="">Select Branch</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('departments.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection