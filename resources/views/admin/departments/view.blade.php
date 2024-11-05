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
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Departments Update'))
                            <a class="btn btn-primary" href="{{ route('departments.edit', $department->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('departments.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Departments Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $department->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $department->id }}"
                                action="{{ route('departments.destroy', $department->id) }}" method="POST"
                                style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection