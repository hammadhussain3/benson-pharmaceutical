@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Product Variation List</h4>
            <h6>Manage your Product Variations</h6>
        </div>
        @if(auth()->user()->hasPermission('Product Variation Create'))
        <div class="page-btn">
            <a href="{{ route('product-variations.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Product Variation
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
                            <th>Product</th>
                            <th>Dosage Forms</th>
                            <th>Pack Forms</th>
                            <th>Packing Types</th>
                            <th>Pack Sizes</th>
                            <th>Trade Price</th>
                            <th>Our MRP</th>
                            <th>Drap MRP</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Product Variation View') || auth()->user()->hasPermission('Product Variation Update') || auth()->user()->hasPermission('Product Variation Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productVariations as $productVariation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('product-variations.show', $productVariation->id) }}">{{ $productVariation->product->brand_name ?? 'N/A' }}</a></td>
                                <td>{{ $productVariation->dosageForm->name ?? 'N/A' }}</td>
                                <td>{{ $productVariation->packForm->name ?? 'N/A' }}</td>
                                <td>{{ $productVariation->packSize->name ?? 'N/A' }}</td>
                                <td>{{ $productVariation->packingType->name ?? 'N/A' }}</td>
                                <td>{{ $productVariation->trade_price ?? 'N/A' }}</td>
                                <td>{{ $productVariation->our_mrp ?? 'N/A' }}</td>
                                <td>{{ $productVariation->drap_mrp ?? 'N/A' }}</td>
                                @role('Superadmin')
                                <td>{{ $productVariation->company->name ?? 'N/A' }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Product Variation View') || auth()->user()->hasPermission('Product Variation Update') || auth()->user()->hasPermission('Product Variation Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Product Variation View'))
                                    <a class="me-3" href="{{ route('product-variations.show', $productVariation->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Product Variation Update'))
                                    <a class="me-3" href="{{ route('product-variations.edit', $productVariation->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Product Variation Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $productVariation->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $productVariation->id }}"
                                        action="{{ route('product-variations.destroy', $productVariation->id) }}" method="POST"
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