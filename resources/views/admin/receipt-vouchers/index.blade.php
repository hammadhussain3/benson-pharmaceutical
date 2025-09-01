@extends('admin.layouts.app')

@section('title', 'Receipt Vouchers List')

@section('content')

    <div class="page-header">
        <div class="page-title">
            <h4>Receipt Voucher List</h4>
            <h6>Manage your Receipt vouchers</h6>
        </div>
        @if(auth()->user()->hasPermission('Receipt Voucher Create'))
        <div class="page-btn">
            <a href="{{ route('receipt-vouchers.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Receipt Voucher
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
                            @if(auth()->user()->hasPermission('Receipt Voucher Update'))
                            <th>Action</th>
                            @endif
                            <th>Franchisers</th>
                            <th>Address</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Total</th>
                            <th>Date</th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            <th>Is Approved</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receiptVouchers as $receiptVoucher)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('receipt-vouchers.show', $receiptVoucher->id) }}">{{ $receiptVoucher->code }}</a></td>
                                @if(auth()->user()->hasPermission('Receipt Voucher Update'))
                                <td>
                                    @if($receiptVoucher->is_approved == 0 || ($receiptVoucher->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                    <a class="me-3" href="{{ route('receipt-vouchers.edit', $receiptVoucher->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                </td>
                                @endif
                                <td>{{ $receiptVoucher->party->name }}</td>
                                <td>{{ $receiptVoucher->party->address }}</td>
                                <td>{{ $receiptVoucher->party->contact_person_name }}</td>
                                <td>{{ $receiptVoucher->party->contact_person_phone ?? $receiptVoucher->party->phone }}</td>
                                <td>{{ $receiptVoucher->total_debit . $receiptVoucher->currency }}</td>
                                <td>{{ $receiptVoucher->total_credit . $receiptVoucher->currency }}</td>
                                <td>{{ $receiptVoucher->total . $receiptVoucher->currency }}</td>
                                <td>{{ $receiptVoucher->created_at->format('d M, Y') }}</td>
                                @role('Superadmin')
                                    <td>{{ $receiptVoucher->company->name }}</td>
                                @endrole
                                <td><span class="badge {{ $receiptVoucher->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $receiptVoucher->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection