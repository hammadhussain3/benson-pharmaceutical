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
                        <div class="mb-3 col-md-12">
                            <label for="name">Leave Type Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $leave_type->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Company Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $leave_type->company->name }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <a class="btn btn-primary" href="{{ route('leaves.edit', $leave_type->id) }}">Update</a>
                            <a class="btn btn-secondary" href="{{ route('leaves.index') }}">Cancel</a>
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $leave_type->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $leave_type->id }}"
                                action="{{ route('leaves.destroy', $leave_type->id) }}" method="POST"
                                style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection