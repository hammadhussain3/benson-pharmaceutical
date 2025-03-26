@extends('admin.layouts.app')

@section('title', 'Employee Types List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Employee Types List</h4>
            <h6>Manage your employee types</h6>
        </div>
        @if(auth()->user()->hasPermission('Employee Type Create'))
        <div class="page-btn">
            <a href="{{ route('employee-types.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Employee Type
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
                            <th>Type</th>
                            <th>Description</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Employee Type View') || auth()->user()->hasPermission('Employee Type Update') || auth()->user()->hasPermission('Employee Type Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeTypes as $key => $employeeType)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><a class="link-primary" href="{{ route('employee-types.show', $employeeType->id) }}">{{ $employeeType->type }}</a></td>
                                <td>{{ $employeeType->description }}</td>
                                @role('Superadmin')
                                <td>{{ $employeeType->company->name ?? 'N/A' }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Employee Type View') || auth()->user()->hasPermission('Employee Type Update') || auth()->user()->hasPermission('Employee Type Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Employee Type View'))
                                    <a class="me-3" href="{{ route('employee-types.show', $employeeType->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Employee Type Update'))
                                    <a class="me-3" href="{{ route('employee-types.edit', $employeeType->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Employee Type Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $employeeType->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $employeeType->id }}"
                                        action="{{ route('employee-types.destroy', $employeeType->id) }}" method="POST"
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