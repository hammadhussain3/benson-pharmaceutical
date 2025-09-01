@extends('admin.layouts.app')
@section('title', 'Banks List')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Banks List</h4>
            <h6>Manage your banks</h6>
        </div>
        @if(auth()->user()->hasPermission('Bank Create'))
        <div class="page-btn">
            <a href="{{ route('banks.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Bank
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
                <table id="example" class="table datanew dataTable no-footer table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bank Name</th>
                            @if(auth()->user()->hasPermission('Bank Update'))
                            <th>Action</th>
                            @endif
                            <th>Acronym</th>
                            <th>Country</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banks as $bank)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-info" href="{{ route('banks.view', $bank->id) }}">{{ $bank->name }}</a></td>
                                @if(auth()->user()->hasPermission('Bank Update'))
                                <td>
                                    @if(auth()->user()->hasPermission('Bank Update'))
                                    <a class="me-3" href="{{ route('banks.edit', $bank->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                </td>
                                @endif
                                <td>{{ $bank->acronym }}</td>
                                <td>{{ $bank->country->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
