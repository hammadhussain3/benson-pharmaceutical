@extends('admin.layouts.app')

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
                            <th>Code</th>
                            <th>Particular</th>
                            <th>Abbreviation</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Chart Of Accounts View') || auth()->user()->hasPermission('Chart Of Accounts Update') || auth()->user()->hasPermission('Chart Of Accounts Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chartOfAccounts as $chartOfAccount)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('chart_of_accounts.view', $chartOfAccount->id) }}">{{ $chartOfAccount->particular }}</a></td>
                                <td>{{ $chartOfAccount->code }}</td>
                                <td>{{ $chartOfAccount->abbreviation }}</td>
                                @role('Superadmin')
                                <td>{{ $chartOfAccount->company->name }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Chart Of Accounts View') || auth()->user()->hasPermission('Chart Of Accounts Update') || auth()->user()->hasPermission('Chart Of Accounts Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Chart Of Accounts View'))
                                    <a class="me-3" href="{{ route('chart_of_accounts.view', $chartOfAccount->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Chart Of Accounts Update'))
                                    <a class="me-3" href="{{ route('chart_of_accounts.edit', $chartOfAccount->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Chart Of Accounts Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $chartOfAccount->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $chartOfAccount->id }}"
                                        action="{{ route('chart_of_accounts.destroy', $chartOfAccount->id) }}"
                                        method="POST" style="display:none;">
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
