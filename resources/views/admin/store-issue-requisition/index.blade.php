@extends('admin.layouts.app')

@section('title', 'Store Issue Rquisitions List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Store Issue Rquisition List</h4>
            <h6>Manage your Store Issue Rquisition</h6>
        </div>
        @if(auth()->user()->hasPermission('Product Create'))
        <div class="page-btn">
            <a href="{{ route('store-issue-requisitions.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Store Issue Rquisition
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
                            <th>Chart Of Account</th>
                            <th>Product</th>
                            <th>Batch No</th>
                            <th>Batch Size</th>
                            <th>DN GP</th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            <th>Is Approved</th>
                            @if(auth()->user()->hasPermission('Store Issue Rquisition View') || auth()->user()->hasPermission('Store Issue Rquisition Update') || auth()->user()->hasPermission('Store Issue Rquisition Delete'))
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requisitions as $requisition)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $requisition->code ?? 'N/A' }}</td>
                                <td>{{ $requisition->chart_of_account->particular ?? 'N/A' }}</td>
                                <td>{{ $requisition->product->name ?? 'N/A' }}</td>
                                <td>{{ $requisition->batch->batch_no ?? 'N/A' }}</td>
                                <td>{{ $requisition->batch->batch_size ?? 'N/A' }}</td>
                                <td>{{ $requisition->dn_gp }}</td>
                                @role('Superadmin')
                                    <td>{{ $requisition->company->name ?? 'N/A' }}</td>
                                @endrole
                                <td><span class="badge {{ $requisition->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $requisition->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                                @if(auth()->user()->hasPermission('Store Issue Rquisition View') || auth()->user()->hasPermission('Store Issue Rquisition Update') || auth()->user()->hasPermission('Store Issue Rquisition Delete'))
                                    <td>
                                        @if(auth()->user()->hasPermission('Store Issue Rquisition View'))
                                            <a class="me-3" href="{{ route('store-issue-requisitions.show', $requisition->id) }}">
                                                <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Store Issue Rquisition Update') && 
                                            ($requisition->is_approved == 0 || ($requisition->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                        )
                                            <a class="me-3" href="{{ route('store-issue-requisitions.edit', $requisition->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Store Issue Rquisition Delete') && 
                                            ($requisition->is_approved == 0 || ($requisition->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                        )
                                            <a class="confirm-text" href="javascript:void(0);"
                                                onclick="confirmDelete('{{ $requisition->id }}')">
                                                <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                            </a>
                                            <form id="delete-form-{{ $requisition->id }}"
                                                action="{{ route('store-issue-requisitions.destroy', $requisition->id) }}" method="POST"
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
