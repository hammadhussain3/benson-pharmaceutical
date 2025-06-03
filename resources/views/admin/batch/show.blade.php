@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Batch Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('batches.index') }}">Batches</a></li>
                    <li class="breadcrumb-item active">Batch Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        <div class="mb-3 col-md-12">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $batch->company->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Chart Of Account</label>
                            <input type="text" class="form-control" value="{{ $batch->chart_of_account->particular ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Sub Chart Of Account</label>
                            <input type="text" class="form-control" value="{{ optional($batch->sub_chart_of_account)->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label>Product</label>
                            <input type="text" class="form-control" value="{{ $batch->product->brand_name ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label>Batch No</label>
                            <input type="text" class="form-control" value="{{ $batch->batch_no ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label>Batch Size</label>
                            <input type="text" class="form-control" value="{{ $batch->batch_size ?? 'N/A' }}" readonly>
                        </div>

                        <div class="col-md-12">
                            <div class="card border-0 mb-0" id="item-group">
                                @for ($i = 0; $i < count($batch->items); $i++)
                                    <div class="item-set">
                                        <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                            <h4 class="card-title mb-0">Item {{ $i + 1 }}</h4>
                                        </div>
                                        <div class="card-body px-0 pb-0">
                                            <div class="row">
                                                <div class="mb-3 col-md-4">
                                                    <label>Product</label>
                                                    <input type="text" class="form-control" value="{{ $batch->product->brand_name ?? null }} | {{ $batch->items[$i]->productVariation->strength ?? null }} | {{ $batch->items[$i]->productVariation->dosageForm->name ?? null }} | {{ $batch->items[$i]->productVariation->packingType->name ?? null }} | {{ $batch->items[$i]->productVariation->packSize->name ?? null }}" readonly>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label>Quantity (Pack)</label>
                                                    <input type="number" class="form-control" value="{{ $batch->items[$i]->quantity ?? 'N/A' }}" readonly>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label>Trade Price</label>
                                                    <input type="number" class="form-control" value="{{ $batch->items[$i]->trade_price ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>MFG date</label>
                            <input type="text" class="form-control" value="{{ $batch->mfg_date ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>EXP date</label>
                            <input type="text" class="form-control" value="{{ $batch->exp_date ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>Start date</label>
                            <input type="text" class="form-control" value="{{ $batch->start_date ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>End date</label>
                            <input type="text" class="form-control" value="{{ $batch->end_date ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>Status</label>
                            <input type="text" class="form-control" value="{{ $batch->status ?? 'N/A' }}" readonly>
                        </div>

                    </div>
                    <a class="btn btn-secondary" href="{{ route('batches.index') }}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection