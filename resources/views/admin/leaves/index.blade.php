@extends('admin.layouts.app')

@section('title', 'Leaves List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Leaves List</h4>
            <h6>Manage your leaves</h6>
        </div>
        @if(auth()->user()->hasPermission('Leave Create'))
        <div class="page-btn">
            <a href="{{ route('leaves.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Leave
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
                            <th>Employee Code</th>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Days</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Month</th>
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
                                <td>{{ $leave->created_at->format('F, Y') }}</td>
                                @if(auth()->user()->hasPermission('Leave View') || auth()->user()->hasPermission('Leave Update') || auth()->user()->hasPermission('Leave Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Leave View'))
                                    <a class="me-3" href="{{ route('leaves.view', $leave->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Leave Update'))
                                    <a class="me-3" href="{{ route('leaves.edit', $leave->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Leave Delete'))
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