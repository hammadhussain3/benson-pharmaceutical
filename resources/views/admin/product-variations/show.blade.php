@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Product Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('product-variations.index') }}">Product Variations</a></li>
                    <li class="breadcrumb-item active">Product Details</li>
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
                        <div class="mb-3 col-md-12">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $productVariation->company->name ?? 'N/A' }}" readonly>
                        </div>
                        @else
                            <input type="hidden" name="company" value="{{ auth()->user()->employee->company_id ?? 0 }}">
                        @endrole
                        <div class="mb-3 col-md-6">
                            <label>Category</label>
                            <input type="text" class="form-control" value="{{ $productVariation->category->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Sub Category</label>
                            <input type="text" class="form-control" value="{{ $productVariation->subCategory->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Chart Of Account</label>
                            <input type="text" class="form-control" value="{{ $productVariation->chart_of_account->particular ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Sub Chart Of Account</label>
                            <input type="text" class="form-control" value="{{ optional($productVariation->sub_chart_of_account)->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Code</label>
                            <input type="text" class="form-control" value="{{ $productVariation->code ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Registration Number</label>
                            <input type="text" class="form-control" value="{{ $productVariation->reg_no ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Brand</label>
                            <input type="text" class="form-control" value="{{ $productVariation->product->brand_name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Strength</label>
                            <input type="text" class="form-control" value="{{ $productVariation->strength ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Dosage Form</label>
                            <input type="text" class="form-control" value="{{ $productVariation->dosageForm->name ?? 'N/A' }}" readonly>
                        </div>
                        {{-- <div class="mb-3 col-md-6">
                            <label>Pack Form</label>
                            <input type="text" class="form-control" value="{{ $productVariation->packForm->name ?? 'N/A' }}" readonly>
                        </div> --}}
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
                        <div class="mb-3 col-md-6">
                            <label>Min Level</label>
                            <input type="text" class="form-control" value="{{ $productVariation->min_level ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Max Level</label>
                            <input type="text" class="form-control" value="{{ $productVariation->max_level ?? 'N/A' }}" readonly>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="{{ route('product-variations.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection