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
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Leave Update'))
                            <a class="btn btn-primary" href="{{ route('leaves.edit', $leave->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('leaves.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Leave Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $leave->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $leave->id }}"
                                action="{{ route('leaves.destroy', $leave->id) }}" method="POST"
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