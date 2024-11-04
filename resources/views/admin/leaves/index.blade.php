@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Leaves List</h4>
            <h6>Manage your leaves</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('leaves.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Leave
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
                            <th>Code</th>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Days</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaves as $leave)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="me-3" href="{{ route('leaves.view', $leave->id) }}">{{ $leave->employee->code }}</a></td>
                                <td>{{ $leave->employee->first_name }} {{ $leave->employee->last_name }}</td>
                                <td>{{ $leave->leaveType->name }}</td>
                                <td>{{ $leave->days }}</td>
                                @role('Superadmin')
                                <td>{{ $leave->company->name }}</td>
                                @endrole
                                <td>
                                <a class="me-3" href="{{ route('leaves.view', $leave->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="Edit">
                                    </a>
                                    <a class="me-3" href="{{ route('leaves.edit', $leave->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $leave->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $leave->id }}"
                                        action="{{ route('leaves.destroy', $leave->id) }}" method="POST"
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