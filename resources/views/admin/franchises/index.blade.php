@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Franchise List</h4>
            <h6>Manage your Franchises</h6>
        </div>
        @if(auth()->user()->hasPermission('Franchise Create'))
        <div class="page-btn">
            <a href="{{ route('franchises.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Franchise
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
                            <th>Name</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Payment Type</th>
                            @if(auth()->user()->hasPermission('Franchise View') || auth()->user()->hasPermission('Franchise Update') || auth()->user()->hasPermission('Franchise Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($franchises as $franchise)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $franchise->name }}</td>
                                <td>{{ $franchise->company_name }}</td>
                                <td>{{ $franchise->email }}</td>
                                <td>{{ $franchise->phone }}</td>
                                <td>{{ $franchise->city->name }}</td>
                                <td>{{ $franchise->address }}</td>
                                <td>{{ $franchise->paymentType->name }}</td>
                                @if(auth()->user()->hasPermission('Franchise View') || auth()->user()->hasPermission('Franchise Update') || auth()->user()->hasPermission('Franchise Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Franchise View'))
                                    <a class="me-3" href="{{ route('franchises.show', $franchise->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Franchise Update'))
                                    <a class="me-3" href="{{ route('franchises.edit', $franchise->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Franchise Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $franchise->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $franchise->id }}"
                                        action="{{ route('franchises.destroy', $franchise->id) }}" method="POST"
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