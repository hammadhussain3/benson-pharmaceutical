@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Leave Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('leaves.index') }}">Leaves</a></li>
                    <li class="breadcrumb-item active">Leave Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        <div class="mb-3 col-md-12">
                            <label for="name">Employee</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $leave->employee->first_name }} {{ $leave->employee->last_name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Company</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $leave->company->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Leave Type</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $leave->leaveType->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Number Of Days</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $leave->days }}" readonly>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('leaves.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection