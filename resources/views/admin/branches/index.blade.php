@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Branches List</h4>
            <h6>Manage your branches</h6>
        </div>
        @if(auth()->user()->hasPermission('Branches Create'))
        <div class="page-btn">
            <a href="{{ route('branches.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Branch
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
                            <th>Branch Name</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Country</th>
                            <th>City</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Status</th>
                            @if(auth()->user()->hasPermission('Branches View') || auth()->user()->hasPermission('Branches Update') || auth()->user()->hasPermission('Branches Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($branches as $branch)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('branches.view', $branch->id) }}">{{ $branch->name }}</a></td>
                                @role('Superadmin')
                                <td>{{ $branch->company->name }}</td>
                                @endrole
                                <td>{{ $branch->country->name }}</td>
                                <td>{{ $branch->city->name }}</td>
                                <td>{{ $branch->phone }}</td>
                                <td>{{ $branch->email }}</td>
                                <td>
                                    <span class="badges {{ $branch->is_active ? 'bg-lightgreen' : 'bg-lightred' }}">
                                        {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                @if(auth()->user()->hasPermission('Branches View') || auth()->user()->hasPermission('Branches Update') || auth()->user()->hasPermission('Branches Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Branches View'))
                                    <a class="me-3" href="{{ route('branches.view', $branch->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Branches Update'))
                                    <a class="me-3" href="{{ route('branches.edit', $branch->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Branches Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $branch->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $branch->id }}"
                                        action="{{ route('branches.destroy', $branch->id) }}" method="POST"
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
