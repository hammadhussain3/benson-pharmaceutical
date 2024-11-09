@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Product Variation Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('product-variations.index') }}">Product Variations</a></li>
                    <li class="breadcrumb-item active">Product Variation Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        @role('Superadmin')
                        <div class="mb-3 col-md-6">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $productVariation->company->name ?? 'N/A' }}" readonly>
                        </div>
                        @else
                            <input type="hidden" name="company" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                        @endrole
                        <div class="mb-3 col-md-6">
                            <label>Product</label>
                            <input type="text" class="form-control" value="{{ $productVariation->product->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Dosage Form</label>
                            <input type="text" class="form-control" value="{{ $productVariation->dosageForm->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Pack Form</label>
                            <input type="text" class="form-control" value="{{ $productVariation->packForm->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Pack Size</label>
                            <input type="text" class="form-control" value="{{ $productVariation->packSize->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Packing Type</label>
                            <input type="text" class="form-control" value="{{ $productVariation->packingType->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Trade Price</label>
                            <input type="text" class="form-control" value="{{ $productVariation->trade_price ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Our MRP</label>
                            <input type="text" class="form-control" value="{{ $productVariation->our_mrp ?? 'N/A' }}" readonly>                            
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Drap MRP</label>
                            <input type="text" class="form-control" value="{{ $productVariation->drap_mrp ?? 'N/A' }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Product Variation Update'))
                            <a class="btn btn-primary" href="{{ route('product-variations.edit', $productVariation->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('product-variations.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Product Variation Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $productVariation->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $productVariation->id }}"
                                action="{{ route('product-variations.destroy', $productVariation->id) }}" method="POST"
                                style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection