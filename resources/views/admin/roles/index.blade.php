@extends('admin.layouts.app')

@section('content')
    <style>
        .dt-buttons {
            display: none;
        }
    </style>
    <div class="page-header">
        <div class="page-title">
            <h4>Roles List</h4>
            <h6>Manage your roles</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('roles.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Roles
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-input">
                        <a class="btn btn-searchset">
                            <img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img">
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table datanew dataTable no-footer table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @foreach ($role->permissions as $permission)
                                        <span class="badges bg-lightgreen">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <a class="me-3" href="{{ route('roles.edit', $role->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="event.preventDefault(); 
                                        if (confirm('Are you sure you want to delete this role?')) {
                                            document.getElementById('delete-form-{{ $role->id }}').submit();
                                        }">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $role->id }}"
                                        action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection