@extends('admin.layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h4>User List</h4>
        <h6>Manage your users</h6>
    </div>
    <div class="page-btn">
        <a href="{{ route('users.register') }}" class="btn btn-added">
            <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Users
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
                        <th>Employee Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        @role('Superadmin')
                        <th>Company</th>
                        @endrole
                        <th>Branch</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                                        @php
                                            $employee = $user->employee;
                                            $company = $employee ? $employee->company : null;
                                            $branch = $employee ? $employee->branch : null;
                                            $department = $employee ? $employee->department : null;
                                        @endphp

                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><a class="link-primary" href="{{ route('users.view', $user->id) }}">{{ $user->employee->code ?? 'N/A' }}</a></td>
                                            <td>{{ $user->name ?? 'N/A' }}</td>
                                            <td>{{ $user->email ?? 'N/A' }}</td>
                                            @role('Superadmin')
                                            <td>{{ $company ? $company->name : 'N/A' }}</td>
                                            @endrole
                                            <td>{{ $branch ? $branch->name : 'N/A' }}</td>
                                            <td>{{ $department ? $department->name : 'N/A' }}</td>
                                            <td>
                                                @foreach ($user->roles as $role)
                                                    @if($role->name == "Admin")
                                                        <span class="badges bg-info mb-1">
                                                            {{ $role->name }}
                                                        </span>
                                                    @endif
                                                    @if($role->name != "Admin")
                                                        <span class="badges bg-lightgreen mb-1">
                                                            {{ $role->name }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <a class="me-3" href="{{ route('users.view', $user->id) }}">
                                                    <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                                </a>
                                                <a class="me-3" href="{{ route('users.edit', $user->id) }}">
                                                    <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                                </a>
                                                <a class="confirm-text" href="javascript:void(0);" onclick="confirmDelete('{{ $user->id }}')">
                                                    <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                                </a>
                                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}"
                                                    method="POST" style="display:none;">
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