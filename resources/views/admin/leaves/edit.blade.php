@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Leave</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('leaves.index') }}">Leaves</a></li>
                    <li class="breadcrumb-item active">Edit Leave</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('leaves.update', $leave->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">

                            @role('Superadmin')
                            <div class="mb-3 col-md-12">
                                <label for="company_id">Company</label>
                                <input type="text" class="form-control" id="company" value="{{ App\Models\Company::where('id', $leave->company_id)->value('name') }}" required readonly>
                                <input type="hidden" name="company" id="company_id" value="{{ $leave->company_id }}" required>
                            </div>
                            @else
                                <input type="hidden" name="company_id" value="{{ $leave->company_id }}">
                            @endrole

                            <div class="mb-3 col-md-12">
                                <label for="employee">Employee</label>
                                <select name="employee" id="employee" class="js-example-basic-single select2" required>
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ $leave->employee_id == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->first_name }} {{ $employee->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select an employee.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="leave_type">Leave Type</label>
                                <select name="leave_type" id="leave_type" class="js-example-basic-single select2"
                                    required>
                                    <option value="">Select Leave Type</option>
                                    @foreach ($leaveTypes as $leaveType)
                                        <option value="{{ $leaveType->id }}"
                                            {{ $leave->leave_type_id == $leaveType->id ? 'selected' : '' }}>
                                            {{ $leaveType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a leave type.</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="days">Number of Days</label>
                                <input type="number" class="form-control" name="days" id="days" placeholder="Days"
                                    value="{{ $leave->days }}" required>
                                <div class="invalid-feedback">Please provide a valid number of days.</div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('leaves.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
