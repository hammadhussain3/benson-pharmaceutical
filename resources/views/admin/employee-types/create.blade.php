@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Employee Type</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employee Types</a></li>
                    <li class="breadcrumb-item active">Add Employee Type</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('employee-types.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="type">Type</label>
                                <input type="text" class="form-control" name="type" id="type" value="{{ old('type') }}"
                                    placeholder="Employee Type" required>
                                <div class="invalid-feedback">Please provide a valid employee type.</div>
                            </div>
                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                <select name="company" id="company_id" class="form-control" required>
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
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                <div class="invalid-feedback">Please employee type description.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('employee-types.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
