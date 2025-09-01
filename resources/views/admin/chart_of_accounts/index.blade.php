@extends('admin.layouts.app')
@section('title', 'Chart Of Accounts List')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Chart of Accounts List</h4>
            <h6>Manage your chart of accounts</h6>
        </div>
        @if(auth()->user()->hasPermission('Chart Of Accounts Create'))
        <div class="page-btn">
            <a href="{{ route('chart_of_accounts.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Chart of Account
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
                            <th>DOC NO</th>
                            @if(auth()->user()->hasPermission('Chart Of Accounts Update'))
                            <th>Action</th>
                            @endif
                            <th>Particular</th>
                            <th>Abbreviation</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chartOfAccounts as $chartOfAccount)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('chart_of_accounts.view', $chartOfAccount->id) }}">{{ $chartOfAccount->particular }}</a></td>
                                @if(auth()->user()->hasPermission('Chart Of Accounts Update'))
                                <td>
                                    <a class="me-3" href="{{ route('chart_of_accounts.edit', $chartOfAccount->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                </td>
                                @endif
                                <td>{{ $chartOfAccount->code }}</td>
                                <td>{{ $chartOfAccount->abbreviation }}</td>
                                @role('Superadmin')
                                <td>{{ $chartOfAccount->company->name }}</td>
                                @endrole
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
