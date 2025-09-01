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
                            <th>DOC NO</th>
                            @if(auth()->user()->hasPermission('Finished Goods Receiving Update'))
                                <th>Action</th>
                            @endif
                            <th >Batch No</th>
                            <th >Product</th>
                            @role('Superadmin')
                                <th>Company</th>
                            @endrole
                            <th>Is Approved</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($finishedGoodsReceivings as $finishedGoodsReceiving)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="me-3" href="{{ route('finished-goods-receivings.show', $finishedGoodsReceiving->id) }}">
                                {{ $finishedGoodsReceiving->code }}</a></td>
                                @if(auth()->user()->hasPermission('Finished Goods Receiving Update'))
                                    <td>
                                        @if(
                                            ($finishedGoodsReceiving->is_approved == 0 || ($finishedGoodsReceiving->is_approved == 1 && auth()->user()->hasPermission('Approved Document Update')))
                                        )
                                            <a class="me-3" href="{{ route('finished-goods-receivings.edit', $finishedGoodsReceiving->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                            </a>
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $finishedGoodsReceiving->batch->batch_no }}</td>
                                <td>{{ $finishedGoodsReceiving->product->brand_name }}</td>
                                @role('Superadmin')
                                <td>{{ $finishedGoodsReceiving->company->name }}</td>
                                @endrole
                                <td><span class="badge {{ $finishedGoodsReceiving->is_approved == 1 ? 'bg-success' : 'bg-danger' }}">{{ $finishedGoodsReceiving->is_approved == 1 ? 'Yes' : 'No' }}</span></td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection