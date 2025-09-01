@extends('admin.layouts.app')

@section('title', 'Rejection Return Notes List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Rejection Return Note List</h4>
            <h6>Manage your Rejection Return Notes</h6>
        </div>
        @if(auth()->user()->hasPermission('Rejection Return Note Create'))
        <div class="page-btn">
            <a href="{{ route('rejection-return-notes.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Rejection Return Note
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
                    <thead class="thead">
                        <tr>
                            <th>#</th>
                            <th>DOC NO</th>
                            @if(auth()->user()->hasPermission('Rejection Return Note Update'))
                                <th>Action</th>
                            @endif
                            <th>Supplier</th>
                            <th>Invoice</th>
                            <th>Supplier Bill No.</th>
                            <th>Batch No.</th>
                            <th>DN/GP/th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            <th>Is Approved</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rejectionReturnNotes as $rejectionReturnNote)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="me-3" href="{{ route('rejection-return-notes.show', $rejectionReturnNote->id) }}">{{ $rejectionReturnNote->code ?? 'N/A' }}</a></td>
                                @if(auth()->user()->hasPermission('Rejection Return Note Update'))
                                    <td>
                                        @if(
                                            ($rejectionReturnNote->is_approved == 0 || ($rejectionReturnNote->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                        )
                                            <a class="me-3" href="{{ route('rejection-return-notes.edit', $rejectionReturnNote->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                            </a>
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $rejectionReturnNote->party->name ?? 'N/A' }}</td>
                                <td>{{ $rejectionReturnNote->invoice->code ?? 'N/A' }}</td>
                                <td>{{ $rejectionReturnNote->supplier_bill_no ?? 'N/A' }}</td>
                                <td>{{ $rejectionReturnNote->batch->batch_no ?? 'N/A' }}</td>
                                <td>{{ $rejectionReturnNote->storeIssueRequisition->dn_gp }}</td>
                                @role('Superadmin')
                                    <td>{{ $rejectionReturnNote->company->name ?? 'N/A' }}</td>
                                @endrole
                                <td><span class="badge {{ $rejectionReturnNote->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $rejectionReturnNote->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection