@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Department Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
                    <li class="breadcrumb-item active">Department Details</li>
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
                            <label>Department Name</label>
                            <input type="text" class="form-control" value="{{ $department->name ?? 'N/A' }}" readonly>
                        </div>

                        @role('Superadmin')
                        <div class="mb-3 col-md-12">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $department->company->name ?? 'N/A' }}" readonly>
                        </div>
                        @endrole

                        <div class="mb-3 col-md-12">
                            <label>Branch</label>
                            <input type="text" class="form-control" value="{{ $department->branch->name ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-12">
                            <label>Description</label>
                            <textarea class="form-control" readonly>{{ $department->description ?? 'N/A' }}</textarea>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('departments.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection