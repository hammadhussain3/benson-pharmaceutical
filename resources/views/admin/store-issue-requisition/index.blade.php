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
                            <th>Doc. No</th>
                            @if(auth()->user()->hasPermission('Store Issue Rquisition Update'))
                                <th>Action</th>
                            @endif
                            <th>Doc. Type</th>
                            <th>Chart Of Account</th>
                            <th>Product</th>
                            <th>Batch No</th>
                            <th>Batch Size</th>
                            <th>DN GP</th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            <th>Is Approved</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requisitions as $requisition)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="me-3" href="{{ route('store-issue-requisitions.show', $requisition->id) }}">{{ $requisition->code ?? 'N/A' }}</a></td>
                                @if(auth()->user()->hasPermission('Store Issue Rquisition Update'))
                                    <td>
                                        @if(
                                            ($requisition->is_approved == 0 || ($requisition->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                        )
                                            <a class="me-3" href="{{ route('store-issue-requisitions.edit', $requisition->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                            </a>
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $requisition->is_general ? 'General' : 'Production' }}</td>
                                <td>{{ $requisition->chart_of_account->particular ?? 'N/A' }}</td>
                                <td>{{ $requisition->product_variation->product->brand_name ?? 'N/A' }}</td>
                                <td>{{ $requisition->batch->batch_no ?? 'N/A' }}</td>
                                <td>{{ $requisition->batch->batch_size ?? 'N/A' }}</td>
                                <td>{{ $requisition->dn_gp }}</td>
                                @role('Superadmin')
                                    <td>{{ $requisition->company->name ?? 'N/A' }}</td>
                                @endrole
                                <td><span class="badge {{ $requisition->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $requisition->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection