@extends('admin.layouts.app')
@section('title', 'Countries List')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Countries List</h4>
            <h6>Manage your countries</h6>
        </div>
        @if(auth()->user()->hasPermission('Countries Create'))
        <div class="page-btn">
            <a href="{{ route('countries.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Country
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
                            <th>Country Name</th>
                            <th>Action</th>
                            <th>Currency</th>
                            @if(auth()->user()->hasPermission('Countries View') || auth()->user()->hasPermission('Countries Update') || auth()->user()->hasPermission('Countries Delete'))
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries as $country)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('countries.view', $country->id) }}">{{ $country->name }}</a></td>
                                @if(auth()->user()->hasPermission('Countries Update'))
                                <td>
                                    <a class="me-3" href="{{ route('countries.edit', $country->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                </td>
                                @endif
                                <td>{{ $country->currency }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
