@extends('admin.layouts.app')

@section('title', 'Goods Receiving Notes List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Goods Receiving Note List</h4>
            <h6>Manage your Goods Receiving Notes</h6>
        </div>
        @if(auth()->user()->hasPermission('Product Create'))
        <div class="page-btn">
            <a href="{{ route('goods-receivings.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Goods Receiving Note
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
                            <th>PO#</th>
                            <th>Supplier</th>
                            <th>Supplier Bill No.</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Sales Tax</th>
                            <th>Adv Tax</th>
                            <th>Total amount</th>
                            <th>Date</th>
                            <th>Is Approved</th>
                            @if(auth()->user()->hasPermission('Goods Receiving View') || auth()->user()->hasPermission('Goods Receiving Update') || auth()->user()->hasPermission('Goods Receiving Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($goodsReceivings as $goodsReceiving)
                            <tr>
                                
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $goodsReceiving->code }}</td>
                                <td>{{ $goodsReceiving->invoice->code }}</td>
                                <td>{{ $goodsReceiving->party->name }}</td>
                                <td>{{ $goodsReceiving->supplier_bill_no }}</td>
                                @role('Superadmin')
                                <td>{{ $goodsReceiving->company->name ?? 'N/A' }}</td>
                                @endrole
                                <td>{{ $goodsReceiving->sales_tax }}</td>
                                <td>{{ $goodsReceiving->adv_tax }}</td>
                                <td>{{ $goodsReceiving->total_amount }}</td>
                                <td>{{ $goodsReceiving->created_at->format('d M, Y') }}</td>
                                <td><span class="badge {{ $goodsReceiving->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $goodsReceiving->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                                @if(auth()->user()->hasPermission('Goods Receiving View') || auth()->user()->hasPermission('Goods Receiving Update') || auth()->user()->hasPermission('Goods Receiving Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Goods Receiving View'))
                                    <a class="me-3" href="{{ route('goods-receivings.show', $goodsReceiving->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Goods Receiving Update') && 
                                        ($goodsReceiving->is_approved == 0 || ($goodsReceiving->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                    )
                                    <a class="me-3" href="{{ route('goods-receivings.edit', $goodsReceiving->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Goods Receiving Delete') && 
                                        ($goodsReceiving->is_approved == 0 || ($goodsReceiving->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                    )
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $goodsReceiving->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $goodsReceiving->id }}"
                                        action="{{ route('goods-receivings.destroy', $goodsReceiving->id) }}" method="POST"
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