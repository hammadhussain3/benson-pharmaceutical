@extends('admin.layouts.app')


@section('content')

    <div class="page-header">
        <div class="page-title">
            <h4>Payment Voucher List</h4>
            <h6>Manage your payment vouchers</h6>
        </div>
        @if(auth()->user()->hasPermission('Payment Voucher Create'))
        <div class="page-btn">
            <a href="{{ route('payment-vouchers.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Payment Voucher
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
                            <th>Supplier</th>
                            <th>Address</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Total</th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Payment Voucher View') || auth()->user()->hasPermission('Payment Voucher Update') || auth()->user()->hasPermission('Payment Voucher Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paymentVouchers as $paymentVoucher)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('payment-vouchers.show', $paymentVoucher->id) }}">{{ $paymentVoucher->created_at->format('d M, Y') }}</a></td>
                                <td>{{ $paymentVoucher->party->name }}</td>
                                <td>{{ $paymentVoucher->party->address }}</td>
                                <td>{{ $paymentVoucher->party->contact_person_name }}</td>
                                <td>{{ $paymentVoucher->party->contact_person_phone ?? $paymentVoucher->party->phone }}</td>
                                <td>{{ $paymentVoucher->total_debit }}</td>
                                <td>{{ $paymentVoucher->total_credit }}</td>
                                <td>{{ $paymentVoucher->total }}</td>
                                @role('Superadmin')
                                    <td>{{ $paymentVoucher->company->name }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Payment Voucher View') || auth()->user()->hasPermission('Payment Voucher Update') || auth()->user()->hasPermission('Payment Voucher Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Payment Voucher View'))
                                    <a class="me-3" href="{{ route('payment-vouchers.show', $paymentVoucher->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Payment Voucher Update'))
                                    <a class="me-3" href="{{ route('payment-vouchers.edit', $paymentVoucher->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Payment Voucher Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $paymentVoucher->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $paymentVoucher->id }}"
                                        action="{{ route('payment-vouchers.destroy', $paymentVoucher->id) }}" method="POST"
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