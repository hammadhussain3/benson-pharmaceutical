@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Role Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">roles</a></li>
                    <li class="breadcrumb-item active">Role Details</li>
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
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $role->name }}" readonly>
                        </div>
                        <div class="mb-3 col-12">
                            @foreach ($role->permissions as $permission)
                                <span class="badges bg-lightgreen mb-1">
                                    {{ $permission->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Roles Update'))
                            <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('roles.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Roles Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $role->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $role->id }}"
                                action="{{ route('roles.destroy', $role->id) }}" method="POST"
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