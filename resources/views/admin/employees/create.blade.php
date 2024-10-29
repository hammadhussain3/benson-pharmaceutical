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
                                    placeholder="First Name" required>
                                <div class="invalid-feedback">Please provide a valid first name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                    placeholder="Last Name" required>
                                <div class="invalid-feedback">Please provide a valid last name.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="basic_pay">Basic Pay</label>
                                <input type="number" step="0.01" class="form-control" name="basic_pay" id="basic_pay"
                                    placeholder="Basic Pay" required>
                                <div class="invalid-feedback">Please provide a valid basic pay amount.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="allowances">Allowances</label>
                                <input type="number" step="0.01" class="form-control" name="allowances" id="allowances"
                                    placeholder="Allowances" required>
                                <div class="invalid-feedback">Please provide valid allowances.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="date_of_joining">Date of Joining</label>
                                <input type="date" class="form-control" name="date_of_joining" id="date_of_joining"
                                    required>
                                <div class="invalid-feedback">Please select a date.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="designation_id">Designation</label>
                                <select name="designation_id" id="designation_id" class="form-control" required>
                                    <option value="">Select Designation</option>
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a designation.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="department_id">Department</label>
                                <select name="department_id" id="department_id" class="form-control" required>
                                    <option value="">Select Department</option>
                                    @role('Superadmin')
                                    @else
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                    @endrole
                                </select>
                                <div class="invalid-feedback">Please select a department.</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="bank_id">Bank (optional)</label>
                                <select name="bank_id" id="bank_id" class="form-control">
                                    <option value="">Select Bank</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="bank_account">Bank Account (optional)</label>
                                <input type="text" class="form-control" name="bank_account" id="bank_account"
                                    placeholder="Bank Account">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="branch_id">Branch</label>
                                <select name="branch_id" id="branch_id" class="form-control" required>
                                    <option value="">Select Branch</option>
                                    @role('Superadmin')
                                    @else
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                    @endrole
                                </select>
                                <div class="invalid-feedback">Please select a branch.</div>
                            </div>
                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                <select name="company_id" id="company_id" class="form-control" required @role('Superadmin') onchange="selectBranches(this.value); selectDepartments(this.value);" @endrole>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            @else
                                <input type="hidden" name="company_id" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                            <div class="mb-3 col-md-6">
                                <label for="is_active">Is Active</label>
                                <select name="is_active" id="is_active" class="form-control" required>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
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
