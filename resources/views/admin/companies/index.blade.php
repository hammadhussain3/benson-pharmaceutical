@extends('admin.layouts.app')
@section('title', 'Companies List')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Companies List</h4>
            <h6>Manage your companies</h6>
        </div>
        @if(auth()->user()->hasPermission('Companies Create'))
        <div class="page-btn">
            <a href="{{ route('companies.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Company
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
                            @if(auth()->user()->hasPermission('Companies Update'))
                            <th>Action</th>
                            @endif
                            <th>Address</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Website</th>
                            <th>NTN</th>
                            <th>STRN</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('companies.view', $company->id) }}">{{ $company->name }}</a></td>
                                @if(auth()->user()->hasPermission('Companies Update'))
                                <td>
                                    <a class="me-3" href="{{ route('companies.edit', $company->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                </td>
                                @endif
                                <td>{{ $company->address }}</td>
                                <td>{{ optional($company->country)->name }}</td>
                                <td>{{ optional($company->city)->name }}</td>
                                <td>{{ $company->phone }}</td>
                                <td>{{ $company->email }}</td>
                                <td>{{ $company->website }}</td>
                                <td>{{ $company->ntn }}</td>
                                <td>{{ $company->strn }}</td>
                                <td>
                                    <span class="badges {{ $company->is_active ? 'bg-whitegreen' : 'bg-whitered' }}">
                                        {{ $company->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
