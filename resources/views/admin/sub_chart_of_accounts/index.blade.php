@extends('admin.layouts.app')
@section('title', 'Sub Chart Of Accounts List')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Sub Chart of Accounts List</h4>
            <h6>Manage your sub chart of accounts</h6>
        </div>
        @if(auth()->user()->hasPermission('Chart Of Accounts Create'))
        <div class="page-btn">
            <a href="{{ route('sub_chart_of_accounts.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1"> Add Sub Chart of Account
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
                            <th>Chart Of Accounts</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Chart Of Accounts View') || auth()->user()->hasPermission('Chart Of Accounts Update') || auth()->user()->hasPermission('Chart Of Accounts Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subChartOfAccounts as $subChartOfAccount)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('sub_chart_of_accounts.show', $subChartOfAccount->id) }}">{{ $subChartOfAccount->name }}</a></td>
                                <td>{{ $subChartOfAccount->chart_of_account->particular }}</td>
                                @role('Superadmin')
                                <td>{{ $subChartOfAccount->company->name }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Chart Of Accounts View') || auth()->user()->hasPermission('Chart Of Accounts Update') || auth()->user()->hasPermission('Chart Of Accounts Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Chart Of Accounts View'))
                                    <a class="me-3" href="{{ route('sub_chart_of_accounts.show', $subChartOfAccount->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Chart Of Accounts Update'))
                                    <a class="me-3" href="{{ route('sub_chart_of_accounts.edit', $subChartOfAccount->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Chart Of Accounts Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $subChartOfAccount->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $subChartOfAccount->id }}"
                                        action="{{ route('sub_chart_of_accounts.destroy', $subChartOfAccount->id) }}"
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
