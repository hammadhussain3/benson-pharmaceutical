@extends('admin.layouts.app')

@section('title', 'Departments List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Departments List</h4>
            <h6>Manage your departments</h6>
        </div>
        @if(auth()->user()->hasPermission('Departments View'))
        <div class="page-btn">
            <a href="{{ route('departments.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Department
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
                            <th>Department Name</th>
                            @if(auth()->user()->hasPermission('Departments View') || auth()->user()->hasPermission('Departments Update') || auth()->user()->hasPermission('Departments Delete'))
                            <th>Action</th>
                            @endif
                            <th>Description</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Branch</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('departments.view', $department->id) }}">{{ $department->name }}</a></td>
                                @if(auth()->user()->hasPermission('Departments Update'))
                                <td>
                                    <a class="me-3" href="{{ route('departments.edit', $department->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                </td>
                                @endif
                                <td>{{ \Illuminate\Support\Str::words($department->description, 10) }}</td>
                                @role('Superadmin')
                                <td>{{ $department->company->name }}</td>
                                @endrole
                                <td>{{ $department->branch ? $department->branch->name : 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection