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
                                <span class="badges bg-whitegreen mb-1">
                                    {{ $permission->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('roles.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>   
@endsection