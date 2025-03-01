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
                            @foreach ($leaveTypes as $leaveType)
                                <th>{{ $leaveType->name }}</th>
                            @endforeach
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            <th>Month</th>
                            <th>Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Group leaves by employee_id, month, and year
                            $groupedLeaves = $leaves->groupBy(function ($leave) {
                                return $leave->employee_id . '-' . $leave->created_at->format('Y-m');
                            });
                        @endphp
                
                        @foreach ($groupedLeaves as $groupKey => $employeeLeaves)
                            @php
                                $firstLeave = $employeeLeaves->first(); // Get first record in group
                                $employee = $firstLeave->employee;
                                $month = $firstLeave->created_at->format('F');
                                $year = $firstLeave->created_at->format('Y');
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a class="me-3" href="{{ route('leaves.view', $firstLeave->id) }}">
                                        {{ $employee->code }}
                                    </a>
                                </td>
                                <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                
                                @foreach ($leaveTypes as $leaveType)
                                    @php
                                        // Find the leave record for the specific leave type in this month and year
                                        $leaveRecord = $employeeLeaves->where('leave_type_id', $leaveType->id)->first();
                                        $leaveDays = $leaveRecord ? $leaveRecord->days : 0; // Default to 0 if no record exists
                                    @endphp
                                    <td>{{ $leaveDays }}</td>
                                @endforeach
                
                                @role('Superadmin')
                                    <td>{{ $firstLeave->company->name }}</td>
                                @endrole
                
                                <td>{{ $month }}</td>
                                <td>{{ $year }}</td>
                
                                @if(auth()->user()->hasPermission('Leave View') || auth()->user()->hasPermission('Leave Update') || auth()->user()->hasPermission('Leave Delete'))
                                    <td>
                                        @if(auth()->user()->hasPermission('Leave View'))
                                            <a class="me-3" href="{{ route('leaves.view', $firstLeave->id) }}">
                                                <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Leave Update'))
                                            <a class="me-3" href="{{ route('leaves.edit', $firstLeave->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Leave Delete'))
                                            <a class="confirm-text" href="javascript:void(0);"
                                               onclick="confirmDelete('{{ $firstLeave->id }}')">
                                                <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                            </a>
                                            <form id="delete-form-{{ $firstLeave->id }}"
                                                  action="{{ route('leaves.destroy', $firstLeave->id) }}" method="POST"
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