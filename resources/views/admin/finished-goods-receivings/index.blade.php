@extends('admin.layouts.app')

@section('title', 'Finished Goods Receiving Notes List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Finished Goods Receiving Note List</h4>
            <h6>Manage your Finished Goods Receiving Notes</h6>
        </div>
        @if(auth()->user()->hasPermission('Product Create'))
        <div class="page-btn">
            <a href="{{ route('finished-goods-receivings.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Finished Goods Receiving Note
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
                            <th >Batch No</th>
                            <th >Product</th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Finished Goods Receiving View') || auth()->user()->hasPermission('Finished Goods Receiving Update') || auth()->user()->hasPermission('Finished Goods Receiving Delete'))
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($finishedGoodsReceivings as $finishedGoodsReceiving)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $finishedGoodsReceiving->code }}</td>
                                <td>{{ $finishedGoodsReceiving->batch->batch_no }}</td>
                                <td>{{ $finishedGoodsReceiving->product->name }}</td>
                                @role('Superadmin')
                                <td>{{ $finishedGoodsReceiving->company->name }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Finished Goods Receiving View') || auth()->user()->hasPermission('Finished Goods Receiving Update') || auth()->user()->hasPermission(' FinishedGoods Receiving Delete'))
                                    <td>
                                        @if(auth()->user()->hasPermission('Finished Goods Receiving View'))
                                            <a class="me-3" href="{{ route('finished-goods-receivings.show', $finishedGoodsReceiving->id) }}">
                                                <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Finished Goods Receiving Update'))
                                            <a class="me-3" href="{{ route('finished-goods-receivings.edit', $finishedGoodsReceiving->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('Finished Goods Receiving Delete'))
                                            <a class="confirm-text" href="javascript:void(0);"
                                                onclick="confirmDelete('{{ $finishedGoodsReceiving->id }}')">
                                                <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                            </a>
                                            <form id="delete-form-{{ $finishedGoodsReceiving->id }}"
                                                action="{{ route('finished-goods-receivings.destroy', $finishedGoodsReceiving->id) }}" method="POST"
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
