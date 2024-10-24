@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Employee</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                    <li class="breadcrumb-item active">Edit Employee</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="code">Employee Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                    value="{{ old('code', $employee->code) }}" required>
                                <div class="invalid-feedback">Please provide a valid employee code.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                    value="{{ old('first_name', $employee->first_name) }}" required>
                                <div class="invalid-feedback">Please provide a valid first name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                    value="{{ old('last_name', $employee->last_name) }}" required>
                                <div class="invalid-feedback">Please provide a valid last name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="basic_pay">Basic Pay</label>
                                <input type="number" step="0.01" class="form-control" name="basic_pay" id="basic_pay"
                                    value="{{ old('basic_pay', $employee->basic_pay) }}" required>
                                <div class="invalid-feedback">Please provide a valid basic pay amount.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="allowances">Allowances</label>
                                <input type="number" step="0.01" class="form-control" name="allowances" id="allowances"
                                    value="{{ old('allowances', $employee->allowances) }}" required>
                                <div class="invalid-feedback">Please provide valid allowances.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="date_of_joining">Date of Joining</label>
                                <input type="date" class="form-control" name="date_of_joining" id="date_of_joining"
                                    value="{{ old('date_of_joining', $employee->date_of_joining) }}" required>
                                <div class="invalid-feedback">Please select a date.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="designation_id">Designation</label>
                                <select name="designation_id" id="designation_id" class="form-control" required>
                                    <option value="">Select Designation</option>
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}"
                                            {{ $designation->id == $employee->designation_id ? 'selected' : '' }}>
                                            {{ $designation->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a designation.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="department_id">Department</label>
                                <select name="department_id" id="department_id" class="form-control" required>
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $department->id == $employee->department_id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a department.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="bank_id">Bank (optional)</label>
                                <select name="bank_id" id="bank_id" class="form-control">
                                    <option value="">Select Bank</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}"
                                            {{ $bank->id == $employee->bank_id ? 'selected' : '' }}>
                                            {{ $bank->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="bank_account">Bank Account (optional)</label>
                                <input type="text" class="form-control" name="bank_account" id="bank_account"
                                    value="{{ old('bank_account', $employee->bank_account) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="branch_id">Branch</label>
                                <select name="branch_id" id="branch_id" class="form-control" required>
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ $branch->id == $employee->branch_id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a branch.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                <select name="company_id" id="company_id" class="form-control" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $company->id == $employee->company_id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="is_active">Is Active</label>
                                <select name="is_active" id="is_active" class="form-control" required>
                                    <option value="1" {{ $employee->is_active ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ !$employee->is_active ? 'selected' : '' }}>No</option>
                                </select>
                                <div class="invalid-feedback">Please select if the employee is active.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('employees.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
