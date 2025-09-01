@extends('admin.layouts.app')

@section('title', 'Cities List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Cities List</h4>
            <h6>Manage your cities</h6>
        </div>
        @if(auth()->user()->hasPermission('Cities Create'))
        <div class="page-btn">
            <a href="{{ route('cities.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add City
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
                            <th>City Name</th>
                            @if(auth()->user()->hasPermission('Cities Update'))
                            <th>Action</th>
                            @endif
                            <th>Country Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cities as $city)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('cities.view', $city->id) }}">{{ $city->name }}</a></td>
                                @if(auth()->user()->hasPermission('Cities Update'))
                                <td>
                                    @if(auth()->user()->hasPermission('Cities Update'))
                                    <a class="me-3" href="{{ route('cities.edit', $city->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                </td>
                                @endif
                                <td>{{ $city->country->name }}</td> <!-- Assuming there is a relationship -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
