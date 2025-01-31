@extends('admin.layouts.app')

@section('title', 'Roles List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Roles List</h4>
            <h6>Manage your roles</h6>
        </div>
        @if(auth()->user()->hasPermission('Roles Create'))
        <div class="page-btn">
            <a href="{{ route('roles.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Roles
            </a>
        </div>
        @endif
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
                            @if(auth()->user()->hasPermission('Roles View') || auth()->user()->hasPermission('Roles Update') || auth()->user()->hasPermission('Roles Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><a class="link-primary" href="{{ route('roles.view', $role->id) }}">{{ $role->name }}</a></td>
                                <td>
                                    @php
                                        $permissionsToShow = $role->permissions->take(4);
                                        $remainingCount = $role->permissions->count() - $permissionsToShow->count();
                                    @endphp
                                
                                    @foreach ($permissionsToShow as $permission)
                                        <span class="badges bg-lightgreen mb-1">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                
                                    @if ($remainingCount > 0)
                                        <span class="badges bg-secondary mb-1">
                                            +{{ $remainingCount }} more
                                        </span>
                                    @endif
                                </td>  
                                @if(auth()->user()->hasPermission('Roles View') || auth()->user()->hasPermission('Roles Update') || auth()->user()->hasPermission('Roles Delete'))                              
                                <td>
                                    @if(auth()->user()->hasPermission('Roles View'))
                                    <a class="me-3" href="{{ route('roles.view', $role->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Roles Update'))
                                    <a class="me-3" href="{{ route('roles.edit', $role->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Roles Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $role->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $role->id }}"
                                        action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection