@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">View New Employee Type</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employee Types</a></li>
                    <li class="breadcrumb-item active">View Employee Type</li>
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
                            <label for="type">Type</label>
                            <input type="text" class="form-control" value="{{ $employeeType->type }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="company">Company</label>
                            <input type="text" class="form-control" value="{{ $employeeType->company->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" readonly>{{ $employeeType->description }}</textarea>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('employee-types.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection
