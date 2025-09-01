@extends('admin.layouts.app')

@section('title', 'Leave Types List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Leave Types List</h4>
            <h6>Manage your leave types</h6>
        </div>
        @if(auth()->user()->hasPermission('Leave Type Create'))
        <div class="page-btn">
            <a href="{{ route('leave_types.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Leave Type
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
                            <th>Leave Type</th>
                            @if(auth()->user()->hasPermission('Leave Type Update'))
                            <th>Action</th>
                            @endif
                            <th>Deduction</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaveTypes as $leaveType)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="me-3" href="{{ route('leave_types.view', $leaveType->id) }}">{{ $leaveType->name }}</a></td>
                                @if(auth()->user()->hasPermission('Leave Type Update'))
                                <td>
                                    <a class="me-3" href="{{ route('leave_types.edit', $leaveType->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                </td>
                                @endif
                                <td>{{ $leaveType->deduction }}%</td>
                                @role('Superadmin')
                                <td>{{ $leaveType->company->name }}</td>
                                @endrole
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection