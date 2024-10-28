@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New Leave</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('leaves.index') }}">Leaves</a></li>
                    <li class="breadcrumb-item active">Add Leave</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('leaves.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-row row">
                            <div class="mb-3 col-md-12">
                                <label for="employee">Employee</label>
                                <select name="employee_id" id="employee" class="js-example-basic-single select2" required @role('Superadmin') onchange="SelectCompany(this.value);" @endrole>
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->first_name }}
                                            {{ $employee->last_name }}</option>
                                        <!-- Assuming you have a full_name attribute -->
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select an employee.</div>
                            </div>
                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company_id">Company</label>
                                <input type="text" class="form-control" name="company" id="company" required readonly>
                                <input type="hidden" name="company_id" id="company_id" required>
                            </div>
                            @else
                                <input type="hidden" name="company_id" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                            @endrole
                            <div class="mb-3 col-md-12">
                                <label for="leave_type">Leave Type</label>
                                <select name="leave_type_id" id="leave_type" class="js-example-basic-single select2"
                                    required>
                                    <option value="">Select Leave Type</option>
                                    @foreach ($leaveTypes as $leaveType)
                                        <option value="{{ $leaveType->id }}">{{ $leaveType->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a leave type.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="days">Number of Days</label>
                                <input type="number" class="form-control" name="days" id="days" placeholder="Days"
                                    required>
                                <div class="invalid-feedback">Please provide a valid number of days.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('leaves.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
