@extends('admin.layouts.app')

@section('title', 'Designations List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Designations List</h4>
            <h6>Manage your designations</h6>
        </div>
        @if(auth()->user()->hasPermission('Designation Update'))
        <div class="page-btn">
            <a href="{{ route('designations.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Designation
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
                            <th>Designation Name</th>
                            @if(auth()->user()->hasPermission('Designation Update'))
                            <th>Action</th>
                            @endif
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($designations as $designation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="me-3" href="{{ route('designations.view', $designation->id) }}">{{ $designation->name }}</a></td>
                                @if(auth()->user()->hasPermission('Designation Update'))
                                <td>
                                    <a class="me-3" href="{{ route('designations.edit', $designation->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                </td>
                                @endif
                                @role('Superadmin')
                                <td>{{ $designation->company->name }}</td>
                                @endrole
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection