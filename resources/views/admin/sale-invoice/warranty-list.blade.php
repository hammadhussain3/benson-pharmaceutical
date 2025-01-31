@extends('admin.layouts.app')

@section('title', 'Sale Warranties List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Sale Warranty List</h4>
            <h6>Manage your sale warranties</h6>
        </div>
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
                            <th>Order Number</th>
                            <th>Order Date</th>
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
                            @if(auth()->user()->hasPermission('Invoice View'))
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('sale-invoices.show', $invoice->id) }}">{{ $invoice->code }}</a></td>
                                <td>{{ ucfirst(strtolower($invoice->type)) }} ({{ $invoice->prefix }})</td>
                                <td>{{ $invoice->party->name }}</td>
                                <td>{{ $invoice->order_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->order_date)->format('d M, Y') }}</td>
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
                                @if(auth()->user()->hasPermission('Invoice View'))
                                    <td>
                                        @if(auth()->user()->hasPermission('Invoice View'))
                                            <a class="me-3" href="{{ route('sale-warranties.show', $invoice->id) }}">
                                                <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                            </a>
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