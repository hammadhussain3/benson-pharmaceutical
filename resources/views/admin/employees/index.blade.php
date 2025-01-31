@extends('admin.layouts.app')

@section('title', 'Employees List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Employees List</h4>
            <h6>Manage your employees</h6>
        </div>
        @if(auth()->user()->hasPermission('Employee Create'))
        <div class="page-btn">
            <a href="{{ route('employees.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Employee
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

                            <th>Emp Code</th>
                            <th>Full Name</th>
                            <th>Contact</th>
                            <th>Date of Joining</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Branch</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Bank</th>
                            <th>Net Salary</th>
                            <th>Status</th>
                            @if(auth()->user()->hasPermission('Employee View') || auth()->user()->hasPermission('Employee Update') || auth()->user()->hasPermission('Employee Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td><a class="link-primary" href="{{ route('employees.view', $employee->id) }}">{{ $employee->code }}</a></td>
                                <td><a class="me-3" href="{{ route('employees.view', $employee->id) }}">{{ $employee->first_name }} {{ $employee->last_name }}</a></td>
                                <td>{{ $employee->email }}<br><small class="text-muted">{{ $employee->phone }}</small></td>
                                <td>{{ $employee->date_of_joining }}</td>
                                <td>{{ $employee->designation->name ?? 'N/A' }}</td>
                                <td>{{ $employee->department->name ?? 'N/A' }}</td>
                                <td>{{ $employee->branch->name ?? 'N/A' }}</td>
                                @role('Superadmin')
                                <td>{{ $employee->company->name ?? 'N/A' }}</td>
                                @endrole
                                <td>{{ $employee->bank->name ?? 'N/A' }}</td>
                                <td>{{ number_format($employee->net_salary, 2) }}</td>
                                <td>
                                    <span class="badges {{ $employee->is_active ? 'bg-lightgreen' : 'bg-lightred' }}">
                                        {{ $employee->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                @if(auth()->user()->hasPermission('Employee View') || auth()->user()->hasPermission('Employee Update') || auth()->user()->hasPermission('Employee Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Employee View'))
                                    <a class="me-3" href="{{ route('employees.view', $employee->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Employee Update'))
                                    <a class="me-3" href="{{ route('employees.edit', $employee->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Employee Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $employee->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $employee->id }}"
                                        action="{{ route('employees.destroy', $employee->id) }}" method="POST"
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