@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Stock List</h4>
            <h6>Manage your Stocks</h6>
        </div>
        @if(auth()->user()->hasPermission('Stock Create'))
        <div class="page-btn">
            <a href="{{ route('stocks.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Stock
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
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Stock View') || auth()->user()->hasPermission('Stock Update') || auth()->user()->hasPermission('Stock Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stocks as $stock)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('stocks.show', $stock->id) }}">{{ $stock->product->name }}</a></td>
                                @role('Superadmin')
                                <td>{{ $stock->company->name ?? 'N/A' }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Stock View') || auth()->user()->hasPermission('Stock Update') || auth()->user()->hasPermission('Stock Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Stock View'))
                                    <a class="me-3" href="{{ route('stocks.show', $stock->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Stock Update'))
                                    <a class="me-3" href="{{ route('stocks.edit', $stock->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Stock Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $stock->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $stock->id }}"
                                        action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
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