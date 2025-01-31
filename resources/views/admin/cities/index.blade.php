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
                            <th>Country Name</th>
                            @if(auth()->user()->hasPermission('Cities View') || auth()->user()->hasPermission('Cities Update') || auth()->user()->hasPermission('Cities Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cities as $city)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('cities.view', $city->id) }}">{{ $city->name }}</a></td>
                                <td>{{ $city->country->name }}</td> <!-- Assuming there is a relationship -->
                                @if(auth()->user()->hasPermission('Cities View') || auth()->user()->hasPermission('Cities Update') || auth()->user()->hasPermission('Cities Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Cities View'))
                                    <a class="me-3" href="{{ route('cities.view', $city->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Cities Update'))
                                    <a class="me-3" href="{{ route('cities.edit', $city->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Cities Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $city->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $city->id }}"
                                        action="{{ route('cities.destroy', $city->id) }}" method="POST"
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
