@extends('admin.layouts.app')

@section('title', 'Brands List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Brand List</h4>
            <h6>Manage your Brands</h6>
        </div>
        @if(auth()->user()->hasPermission('Product Create'))
        <div class="page-btn">
            <a href="{{ route('products.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Brand
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
                            {{-- <th>Name</th>
                            <th>Registration No.</th> --}}
                            <th>Generic Name</th>
                            <th>Brand Name</th>
                            <th>Therapeutic Class</th>
                            {{-- <th>Code</th>
                            <th>Group</th> --}}
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Product View') || auth()->user()->hasPermission('Product Update') || auth()->user()->hasPermission('Product Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td><a class="link-primary" href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></td>
                                <td>{{ $product->reg_no }}</td> --}}
                                <td><a class="link-primary" href="{{ route('products.show', $product->id) }}">{{ $product->generic_name }}</a></td>
                                <td>{{ $product->brand_name }}</td>
                                <td>{{ $product->therapeutic_class }}</td>
                                {{-- <td>{{ $product->code }}</td>
                                <td>{{ $product->productGroup->name }}</td> --}}
                                @role('Superadmin')
                                <td>{{ $product->company->name ?? 'N/A' }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Product View') || auth()->user()->hasPermission('Product Update') || auth()->user()->hasPermission('Product Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Product View'))
                                    <a class="me-3" href="{{ route('products.show', $product->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Product Update'))
                                    <a class="me-3" href="{{ route('products.edit', $product->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Product Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $product->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $product->id }}"
                                        action="{{ route('products.destroy', $product->id) }}" method="POST"
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
