@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Designation Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('designations.index') }}">Designations</a></li>
                    <li class="breadcrumb-item active">Designation Details</li>
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
                            <label for="name">Designation Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $designations->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Company Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $designations->company->name }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Designation Update'))
                            <a class="btn btn-primary" href="{{ route('designations.edit', $designations->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('designations.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Designation Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $designations->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $designations->id }}"
                                action="{{ route('designations.destroy', $designations->id) }}" method="POST"
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