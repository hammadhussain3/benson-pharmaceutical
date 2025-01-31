@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Leave Type Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('leaves.index') }}">Leave Types</a></li>
                    <li class="breadcrumb-item active">Leave Type Details</li>
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
                            <label>Leave Type Name</label>
                            <input type="text" class="form-control" value="{{ $leave_type->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Deduction</label>
                            <input type="text" class="form-control" value="{{ $leave_type->deduction }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label>Company Name</label>
                            <input type="text" class="form-control" value="{{ $leave_type->company->name }}" readonly>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('leaves.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection