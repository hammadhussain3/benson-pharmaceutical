@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Employee Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                    <li class="breadcrumb-item active">Employee Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        <div class="mb-3 col-md-6">
                            <label for="code">Employee Code</label>
                            <input type="text" class="form-control" name="code" id="code" value="{{ $employees->code }}"
                                placeholder="Employee Code" readonly >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name"
                                placeholder="First Name"  value="{{ $employees->first_name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name"
                                placeholder="Last Name"  value="{{ $employees->last_name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Email"  value="{{ $employees->email }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control" name="phone" id="phone"
                                placeholder="+123 1234567890"  value="{{ $employees->phone }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="basic_pay">Basic Pay</label>
                            <input type="number" step="0.01" class="form-control" name="basic_pay" id="basic_pay"
                                placeholder="Basic Pay"  value="{{ $employees->basic_pay }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="allowances">Allowances</label>
                            <input type="number" step="0.01" class="form-control" name="allowances" id="allowances"
                                placeholder="Allowances"  value="{{ $employees->allowances }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="date_of_joining">Date of Joining</label>
                            <input type="date" class="form-control" name="date_of_joining" id="date_of_joining"
                                    max="{{ date('Y-m-d') }}" value="{{ $employees->date_of_joining }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="date_of_appointment">Date of Appointment</label>
                            <input type="date" class="form-control" name="date_of_appointment" id="date_of_appointment"
                                    max="{{ date('Y-m-d') }}" value="{{ $employees->date_of_appointment }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="company_id">Company</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $employees->company->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="branch_id">Branch</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $employees->branch->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="department_id">Department</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $employees->department->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="designation_id">Designation</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $employees->designation->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="bank_id">Bank</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $employees->bank->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="bank_account">Bank Account</label>
                            <input type="text" class="form-control" value="{{ $employees->bank_account ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="employee_type">Employee Type</label>
                            <input type="text" class="form-control" value="{{ $employees->employee_type->type ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="is_active">Is Active</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $employees->is_active == '1' ? 'Yes' : 'No' }}" readonly>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('employees.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection