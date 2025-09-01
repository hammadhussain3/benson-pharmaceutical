@extends('admin.layouts.app')

@section('title', 'Journal Vouchers List')

@section('content')

    <div class="page-header">
        <div class="page-title">
            <h4>Journal Voucher List</h4>
            <h6>Manage your Journal vouchers</h6>
        </div>
        @if(auth()->user()->hasPermission('Journal Voucher Create'))
        <div class="page-btn">
            <a href="{{ route('journal-vouchers.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Journal Voucher
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
                            @if(auth()->user()->hasPermission('Journal Voucher Update'))
                            <th>Action</th>
                            @endif
                            <th>Year</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Date</th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            <th>Is Approved</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($journalVouchers as $journalVoucher)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('journal-vouchers.show', $journalVoucher->id) }}">{{ $journalVoucher->code }}</a></td>
                                @if(auth()->user()->hasPermission('Journal Voucher Update'))
                                    <td>
                                        @if($journalVoucher->is_approved == 0 || ($journalVoucher->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                        <a class="me-3" href="{{ route('journal-vouchers.edit', $journalVoucher->id) }}">
                                            <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                        </a>
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $journalVoucher->year }}</td>
                                <td>{{ $journalVoucher->total_debit . $journalVoucher->currency }}</td>
                                <td>{{ $journalVoucher->total_credit . $journalVoucher->currency }}</td>
                                <td>{{ $journalVoucher->created_at->format('d M, Y') }}</td>
                                @role('Superadmin')
                                    <td>{{ $journalVoucher->company->name }}</td>
                                @endrole
                                <td><span class="badge {{ $journalVoucher->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $journalVoucher->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection