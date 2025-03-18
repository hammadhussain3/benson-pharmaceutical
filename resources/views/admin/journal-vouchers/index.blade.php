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
                            <th>Code</th>
                            <th>Year</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Date</th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            <th>Is Approved</th>
                            @if(auth()->user()->hasPermission('Journal Voucher View') || auth()->user()->hasPermission('Journal Voucher Update') || auth()->user()->hasPermission('Journal Voucher Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($journalVouchers as $journalVoucher)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('journal-vouchers.show', $journalVoucher->id) }}">{{ $journalVoucher->code }}</a></td>
                                <td>{{ $journalVoucher->year }}</td>
                                <td>{{ $journalVoucher->total_debit . $journalVoucher->currency }}</td>
                                <td>{{ $journalVoucher->total_credit . $journalVoucher->currency }}</td>
                                <td>{{ $journalVoucher->created_at->format('d M, Y') }}</td>
                                @role('Superadmin')
                                    <td>{{ $journalVoucher->company->name }}</td>
                                @endrole
                                <td><span class="badge {{ $journalVoucher->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $journalVoucher->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                                @if(auth()->user()->hasPermission('Journal Voucher View') || auth()->user()->hasPermission('Journal Voucher Update') || auth()->user()->hasPermission('Journal Voucher Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Journal Voucher View'))
                                    <a class="me-3" href="{{ route('journal-vouchers.show', $journalVoucher->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Journal Voucher Update') && 
                                        ($journalVoucher->is_approved == 0 || ($journalVoucher->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                    )
                                    <a class="me-3" href="{{ route('journal-vouchers.edit', $journalVoucher->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Journal Voucher Delete') && 
                                        ($journalVoucher->is_approved == 0 || ($journalVoucher->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                    )
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $journalVoucher->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $journalVoucher->id }}"
                                        action="{{ route('journal-vouchers.destroy', $journalVoucher->id) }}" method="POST"
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