@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Leave Type</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('leave_types.index') }}">Leave Types</a></li>
                    <li class="breadcrumb-item active">Add Leave Type</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('leave_types.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="name">Leave Type Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Leave Type Name" required value="{{ old('name') }}">
                                <div class="invalid-feedback">Please provide a valid leave type name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="deduction">Deduction (%)</label>
                                <input type="number" class="form-control" name="deduction" id="deduction"
                                    placeholder="Deduction Amount Per Day" min="0" max="200" step="0.01" required value="{{ old('deduction') }}">
                                <div class="invalid-feedback">Please provide a valid deduction amount.</div>
                            </div>
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company">Company</label>
                                <select name="company" id="company" class="js-example-basic-single select2" required>
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
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('leave_types.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
