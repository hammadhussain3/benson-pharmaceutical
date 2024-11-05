@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Employee</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                    <li class="breadcrumb-item active">Add Employee</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('employees.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="code">Employee Code</label>
                                <input type="text" class="form-control" name="code" id="code" value="{{ $newEmployeeCode }}"
                                    placeholder="Employee Code" readonly required>
                                <div class="invalid-feedback">Please provide a valid employee code.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                    placeholder="First Name" required value="{{ old('first_name') }}">
                                <div class="invalid-feedback">Please provide a valid first name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                    placeholder="Last Name" required value="{{ old('last_name') }}">
                                <div class="invalid-feedback">Please provide a valid last name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Email" required value="{{ old('email') }}">
                                <div class="invalid-feedback">Please provide a valid first name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" name="phone" id="phone"
                                    placeholder="+123 1234567890" required value="{{ old('phone') }}">
                                <div class="invalid-feedback">Please provide a valid last name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="basic_pay">Basic Pay</label>
                                <input type="number" step="0.01" class="form-control" name="basic_pay" id="basic_pay"
                                    placeholder="Basic Pay" required value="{{ old('basic_pay') }}">
                                <div class="invalid-feedback">Please provide a valid basic pay amount.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="allowances">Allowances</label>
                                <input type="number" step="0.01" class="form-control" name="allowances" id="allowances"
                                    placeholder="Allowances" required value="{{ old('allowances') }}">
                                <div class="invalid-feedback">Please provide valid allowances.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="date_of_joining">Date of Joining</label>
                                <input type="date" class="form-control" name="date_of_joining" id="date_of_joining"
                                    required max="{{ date('Y-m-d') }}" value="{{ old('date_of_joining') }}">
                                <div class="invalid-feedback">Please select a date.</div>
                            </div>
                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                <select name="company" id="company_id" class="form-control" required value="{{ old('company') }}" @role('Superadmin') onchange="selectBranches(this.value); selectDepartments(this.value); selectDesignations(this.value); createEmployeeCode(this.value);" @endrole>
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
                            <div class="mb-3 col-md-6">
                                <label for="branch_id">Branch</label>
                                <select name="branch" id="branch_id" class="form-control" required value="{{ old('branch') }}" onchange="selectDepartmentsByBranch(this.value);">
                                    <option value="">Select Branch</option>
                                    @if(old('branch') || old('company'))
                                        @foreach ($branches->where('company_id', old('company')) as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ old('branch') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">Please select a branch.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="department_id">Department</label>
                                <select name="department" id="department_id" class="form-control" required value="{{ old('department') }}">
                                    <option value="">Select Department</option>
                                    @if(old('department') || old('branch'))
                                        @foreach ($departments->where('branch_id', old('branch')) as $department)
                                            <option value="{{ $department->id }}"
                                                {{ old('department') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">Please select a department.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="designation_id">Designation</label>
                                <select name="designation" id="designation_id" class="form-control" required value="{{ old('designation') }}">
                                    <option value="">Select Designation</option>
                                    @if(old('designation') || old('company'))
                                        @foreach ($designations->where('company_id', old('company')) as $designation)
                                            <option value="{{ $designation->id }}"
                                                {{ old('designation') == $designation->id ? 'selected' : '' }}>
                                                {{ $designation->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">Please select a designation.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="bank_id">Bank (optional)</label>
                                <select name="bank" id="bank_id" class="form-control" value="{{ old('bank') }}">
                                    <option value="">Select Bank</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="bank_account">Bank Account (optional)</label>
                                <input type="number" class="form-control" name="bank_account" id="bank_account"
                                    placeholder="Bank Account" value="{{ old('bank_account') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="is_active">Is Active</label>
                                <select name="is_active" id="is_active" class="form-control" required>
                                    <option value="1" {{ old('is_active', 1) == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ old('is_active', 1) == '0' ? 'selected' : '' }}>No</option>
                                </select>
                                <div class="invalid-feedback">Please select if the employee is active.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('employees.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
