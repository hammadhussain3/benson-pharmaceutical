@extends('admin.layouts.app')


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
                            <th>Date</th>
                            <th>Franchisers</th>
                            <th>Address</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Total</th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Receipt Voucher View') || auth()->user()->hasPermission('Receipt Voucher Update') || auth()->user()->hasPermission('Receipt Voucher Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receiptVouchers as $receiptVoucher)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('receipt-vouchers.show', $receiptVoucher->id) }}">{{ $receiptVoucher->created_at->format('d M, Y') }}</a></td>
                                <td>{{ $receiptVoucher->party->name }}</td>
                                <td>{{ $receiptVoucher->party->address }}</td>
                                <td>{{ $receiptVoucher->party->contact_person_name }}</td>
                                <td>{{ $receiptVoucher->party->contact_person_phone ?? $receiptVoucher->party->phone }}</td>
                                <td>{{ $receiptVoucher->total_debit }}</td>
                                <td>{{ $receiptVoucher->total_credit }}</td>
                                <td>{{ $receiptVoucher->total }}</td>
                                @role('Superadmin')
                                    <td>{{ $receiptVoucher->company->name }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Receipt Voucher View') || auth()->user()->hasPermission('Receipt Voucher Update') || auth()->user()->hasPermission('Receipt Voucher Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Receipt Voucher View'))
                                    <a class="me-3" href="{{ route('receipt-vouchers.show', $receiptVoucher->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Receipt Voucher Update'))
                                    <a class="me-3" href="{{ route('receipt-vouchers.edit', $receiptVoucher->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Receipt Voucher Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $receiptVoucher->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $receiptVoucher->id }}"
                                        action="{{ route('receipt-vouchers.destroy', $receiptVoucher->id) }}" method="POST"
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