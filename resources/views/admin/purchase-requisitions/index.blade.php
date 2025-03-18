@extends('admin.layouts.app')

@section('title', 'Manual Purchase Requisitions List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Manual Purchase Requisition List</h4>
            <h6>Manage your Purchase Requisitions</h6>
        </div>
        @if(auth()->user()->hasPermission('Purchase Requisition Create'))
        <div class="page-btn">
            <a href="{{ route('purchase-requisitions.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Manual Purchase Requisition
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
                            <th>Ref No.</th>
                            <th>Required Date</th>
                            <th>Total Amount</th>
                            <th>Supplier</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Date</th>
                            <th>Is Approved</th>
                            @if(auth()->user()->hasPermission('Purchase Requisition View') || auth()->user()->hasPermission('Purchase Requisition Update') || auth()->user()->hasPermission('Purchase Requisition Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseRequisitions as $purchaseRequisition)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('purchase-requisitions.show', $purchaseRequisition->id) }}">{{ $purchaseRequisition->code }}</a></td>
                                <td>{{ \Carbon\Carbon::parse($purchaseRequisition->required_date)->format('d M, Y') }}</td>
                                <td>{{ number_format($purchaseRequisition->total_amount, 2) }}</td>
                                <td>{{ $purchaseRequisition->supplier->name }}</td>
                                @role('Superadmin')
                                <td>{{ $purchaseRequisition->company->name ?? 'N/A' }}</td>
                                @endrole
                                <td>{{ $purchaseRequisition->created_at->format('d M, Y') }}</td>
                                <td><span class="badge {{ $purchaseRequisition->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $purchaseRequisition->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                                @if(auth()->user()->hasPermission('Purchase Requisition View') || auth()->user()->hasPermission('Purchase Requisition Update') || auth()->user()->hasPermission('Purchase Requisition Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Purchase Requisition View'))
                                    <a class="me-3" href="{{ route('purchase-requisitions.show', $purchaseRequisition->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Purchase Requisition Update') && 
                                        ($purchaseRequisition->is_approved == 0 || ($purchaseRequisition->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                    )
                                    <a class="me-3" href="{{ route('purchase-requisitions.edit', $purchaseRequisition->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Purchase Requisition Delete') && 
                                        ($purchaseRequisition->is_approved == 0 || ($purchaseRequisition->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                    )
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $purchaseRequisition->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $purchaseRequisition->id }}"
                                        action="{{ route('purchase-requisitions.destroy', $purchaseRequisition->id) }}" method="POST"
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