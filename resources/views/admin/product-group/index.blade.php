@extends('admin.layouts.app')

@section('title', 'Product Groups List')

@section('content')

    <div class="page-header">
        <div class="page-title">
            <h4>Product Group List</h4>
            <h6>Manage your product group</h6>
        </div>
        @if(auth()->user()->hasPermission('ProductGroup Create'))
        <div class="page-btn">
            <a href="{{ route('product-groups.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Product Group
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
                            <th>Name</th>
                            @if(auth()->user()->hasPermission('ProductGroup Update'))
                            <th>Action</th>
                            @endif
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productGroups as $productGroup)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('product-groups.show', $productGroup->id) }}">{{ $productGroup->name }}</a></td>
                                @if(auth()->user()->hasPermission('ProductGroup Update'))
                                <td>
                                    <a class="me-3" href="{{ route('product-groups.edit', $productGroup->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>   
                                </td>
                                @endif
                                @role('Superadmin')
                                <td>{{ $productGroup->company->name }}</td>
                                @endrole
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
