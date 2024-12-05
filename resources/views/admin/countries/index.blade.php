@extends('admin.layouts.app')

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
                            <th>Currency</th>
                            @if(auth()->user()->hasPermission('Countries View') || auth()->user()->hasPermission('Countries Update') || auth()->user()->hasPermission('Countries Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries as $country)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('countries.view', $country->id) }}">{{ $country->name }}</a></td>
                                <td>{{ $country->currency }}</td>
                                @if(auth()->user()->hasPermission('Countries View') || auth()->user()->hasPermission('Countries Update') || auth()->user()->hasPermission('Countries Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Countries View'))
                                    <a class="me-3" href="{{ route('countries.view', $country->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Countries Update'))
                                    <a class="me-3" href="{{ route('countries.edit', $country->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Countries Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $country->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $country->id }}"
                                        action="{{ route('countries.destroy', $country->id) }}" method="POST"
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
