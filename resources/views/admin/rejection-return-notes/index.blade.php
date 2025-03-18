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
                            <th>Code</th>
                            <th>Supplier</th>
                            <th>Invoice</th>
                            <th>Supplier Bill No.</th>
                            <th>Batch No.</th>
                            <th>DN/GP/th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            <th>Is Approved</th>
                            @if(auth()->user()->hasPermission('Rejection Return Note View') || auth()->user()->hasPermission('Rejection Return Note Update') || auth()->user()->hasPermission('Rejection Return Note Delete'))
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rejectionReturnNotes as $rejectionReturnNote)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rejectionReturnNote->code ?? 'N/A' }}</td>
                                <td>{{ $rejectionReturnNote->party->name ?? 'N/A' }}</td>
                                <td>{{ $rejectionReturnNote->invoice->code ?? 'N/A' }}</td>
                                <td>{{ $rejectionReturnNote->supplier_bill_no ?? 'N/A' }}</td>
                                <td>{{ $rejectionReturnNote->batch->batch_no ?? 'N/A' }}</td>
                                <td>{{ $rejectionReturnNote->storeIssueRequisition->dn_gp }}</td>
                                @role('Superadmin')
                                    <td>{{ $rejectionReturnNote->company->name ?? 'N/A' }}</td>
                                @endrole
                                <td><span class="badge {{ $rejectionReturnNote->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $rejectionReturnNote->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                                @if(auth()->user()->hasPermission('Rejection Return Note View') || auth()->user()->hasPermission('Rejection Return Note Update') || auth()->user()->hasPermission('Rejection Return Note Delete'))
                                    <td>
                                        @if(auth()->user()->hasPermission('Rejection Return Note View'))
                                            <a class="me-3" href="{{ route('rejection-return-notes.show', $rejectionReturnNote->id) }}">
                                                <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Rejection Return Note Update') && 
                                            ($rejectionReturnNote->is_approved == 0 || ($rejectionReturnNote->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                        )
                                            <a class="me-3" href="{{ route('rejection-return-notes.edit', $rejectionReturnNote->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Rejection Return Note Delete') && 
                                            ($rejectionReturnNote->is_approved == 0 || ($rejectionReturnNote->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                        )
                                            <a class="confirm-text" href="javascript:void(0);"
                                                onclick="confirmDelete('{{ $rejectionReturnNote->id }}')">
                                                <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                            </a>
                                            <form id="delete-form-{{ $rejectionReturnNote->id }}"
                                                action="{{ route('rejection-return-notes.destroy', $rejectionReturnNote->id) }}" method="POST"
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