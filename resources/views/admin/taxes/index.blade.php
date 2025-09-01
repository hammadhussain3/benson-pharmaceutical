@extends('admin.layouts.app')

@section('title', 'Taxes List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Tax List</h4>
            <h6>Manage your Taxes</h6>
        </div>
        @if(auth()->user()->hasPermission('Tax Create'))
        <div class="page-btn">
            <a href="{{ route('taxes.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Tax
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
                            @if(auth()->user()->hasPermission('Tax Update'))
                            <th>Action</th>
                            @endif
                            <th>Rate</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($taxes as $tax)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('taxes.show', $tax->id) }}">{{ $tax->name }}</a></td>
                                @if(auth()->user()->hasPermission('Tax Update'))
                                <td>
                                    @if(auth()->user()->hasPermission('Tax Update'))
                                    <a class="me-3" href="{{ route('taxes.edit', $tax->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                </td>
                                @endif
                                <td>{{ $tax->rate }}%</td>
                                @role('Superadmin')
                                <td>{{ $tax->company->name ?? 'N/A' }}</td>
                                @endrole
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection