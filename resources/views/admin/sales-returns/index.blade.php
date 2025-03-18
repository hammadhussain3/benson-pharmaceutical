@extends('admin.layouts.app')

@section('title', 'Sales Returns List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Sales Return List</h4>
            <h6>Manage your sales returns</h6>
        </div>
        @if(auth()->user()->hasPermission('Sales Return Create'))
        <div class="page-btn">
            <a href="{{ route('sales-returns.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Sales Return
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
                            <th>Party</th>
                            <th>Discount</th>
                            <th>Total Amount</th>
                            <th>Date</th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            <th>Is Approved</th>
                            @if(auth()->user()->hasPermission('Sales Return View') || auth()->user()->hasPermission('Sales Return Update') || auth()->user()->hasPermission('Sales Return Delete'))
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salesReturns as $salesReturn)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('sales-returns.show', $salesReturn->id) }}">{{ $salesReturn->code }}</a></td>
                                <td>{{ $salesReturn->party->name }}</td>
                                <td>{{ $salesReturn->discount_type }} - {{ $salesReturn->discount }}</td>
                                <td>{{ $salesReturn->total_amount }}</td>
                                <td>{{ $salesReturn->created_at->format('d M, Y') }}</td>
                                @role('Superadmin')
                                    <td>{{ $salesReturn->company->name }}</td>
                                @endrole
                                <td><span class="badge {{ $salesReturn->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $salesReturn->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                                @if(auth()->user()->hasPermission('Sales Return View') || auth()->user()->hasPermission('Sales Return Update') || auth()->user()->hasPermission('Sales Return Delete'))
                                    <td>
                                        @if(auth()->user()->hasPermission('Sales Return View'))
                                            <a class="me-3" href="{{ route('sales-returns.show', $salesReturn->id) }}">
                                                <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Sales Return Update') && 
                                            ($salesReturn->is_approved == 0 || ($salesReturn->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                        )
                                            <a class="me-3" href="{{ route('sales-returns.edit', $salesReturn->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Sales Return Delete') && 
                                            ($salesReturn->is_approved == 0 || ($salesReturn->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                        )
                                            <a class="confirm-text" href="javascript:void(0);"
                                                onclick="confirmDelete('{{ $salesReturn->id }}')">
                                                <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                            </a>
                                            <form id="delete-form-{{ $salesReturn->id }}"
                                                action="{{ route('sales-returns.destroy', $salesReturn->id) }}" method="POST"
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