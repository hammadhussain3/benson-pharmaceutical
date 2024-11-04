@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Employees List</h4>
            <h6>Manage your employees</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('employees.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Employee
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
                            <th>Action</th>
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
                                <td>
                                    <a class="me-3" href="{{ route('employees.view', $employee->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="Edit">
                                    </a>
                                    <a class="me-3" href="{{ route('employees.edit', $employee->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
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

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection