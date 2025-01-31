@extends('admin.layouts.app')

@section('title', 'Purchase Invoices List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Invoice List</h4>
            <h6>Manage your Invoices</h6>
        </div>
        @if(auth()->user()->hasPermission('Invoice Create'))
        <div class="page-btn">
            <a href="{{ route('purchase-invoices.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Invoice
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
                            <th>Type</th>
                            <th>Party</th>
                            <th>Required Date</th>
                            <th>Is Urgent</th>
                            <th>Status</th>
                            <th>Discount</th>
                            <th>Paid Amount</th>
                            <th>Returned Amount</th>
                            <th>Due Amount</th>
                            <th>Total Amount</th>
                            <th>Payment Status</th>
                            <th>Invoice Date</th>
                            @role('Superadmin')
                            <th>Company Id</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Invoice View') || auth()->user()->hasPermission('Invoice Update') || auth()->user()->hasPermission('Invoice Delete'))
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('purchase-invoices.show', $invoice->id) }}">{{ $invoice->code }}</a></td>
                                <td>{{ ucfirst(strtolower($invoice->type)) }} ({{ $invoice->prefix }})</td>
                                <td>{{ $invoice->party->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->required_date)->format('d M, Y') }}</td>
                                <td>{{ $invoice->is_urgent == '1' ? 'Yes' : 'No' }}</td>
                                <td>{{ $invoice->status }}</td>
                                <td>{{ $invoice->discount_type }} - {{ $invoice->discount }}</td>
                                <td>{{ $invoice->paid_amount }}</td>
                                <td>{{ $invoice->returned_amount }}</td>
                                <td>{{ $invoice->due_amount }}</td>
                                <td>{{ $invoice->total_amount }}</td>
                                <td>{{ $invoice->payment_status }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</td>
                                @role('Superadmin')
                                    <td>{{ $invoice->company->name }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Invoice View') || auth()->user()->hasPermission('Invoice Update') || auth()->user()->hasPermission('Invoice Delete'))
                                    <td>
                                        @if(auth()->user()->hasPermission('Invoice View'))
                                            <a class="me-3" href="{{ route('purchase-invoices.show', $invoice->id) }}">
                                                <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Invoice Update'))
                                            <a class="me-3" href="{{ route('purchase-invoices.edit', $invoice->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Invoice Delete'))
                                            <a class="confirm-text" href="javascript:void(0);"
                                                onclick="confirmDelete('{{ $invoice->id }}')">
                                                <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                            </a>
                                            <form id="delete-form-{{ $invoice->id }}"
                                                action="{{ route('purchase-invoices.destroy', $invoice->id) }}" method="POST"
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