@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Stock Bin Card</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Stock Bin Card</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="printWithTimestamp()">Print Report</button>
        </div>
    </div>

    <div class="mb-3">
        <form action="{{ route('reports.stock-bin-card') }}" class="row gy-2 gx-3 align-items-end" method="get">
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="from_date">From</label>
                <input type="date" class="form-control" name="from_date" id="from_date" value="{{ $from_date }}">
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="to_date">To</label>
                <input type="date" class="form-control" name="to_date" id="to_date" value="{{ $to_date }}">
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="product">Products</label>
                <select name="product" id="product" class="js-example-basic-single select2">
                    <option value="">Select Product</option>
                    <optgroup label="Final Products">
                        @foreach ($finalProducts as $finalProduct)
                            <option value="{{ 'product_'.$finalProduct->id }}" 
                                {{ isset($productType, $product) && $productType == 1 && $product->id == $finalProduct->id ? 'selected' : '' }}>
                                {{ $finalProduct->product->name }}
                            </option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Raw Materials">
                        @foreach ($rawMaterials as $rawMaterial)
                            <option value="{{ 'raw_'.$rawMaterial->id }}" 
                                {{ isset($productType, $product) && $productType == 1 && $product->id == $rawMaterial->id ? 'selected' : '' }}>
                                {{ $rawMaterial->name }}
                            </option>
                        @endforeach
                    </optgroup>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>            
        </form>
    </div>

    <div class="card">
        <div class="card-body px-0 pb-0">
            <h5 class="text-center card-title mb-0">Stock Bin Card</h5>
            <p class="text-center text-muted mb-2">From {{ \Carbon\Carbon::create($from_date)->format('d M, Y') }} to {{ \Carbon\Carbon::create($to_date)->format('d M, Y') }}</p>
            @if ($productType && $productType == 0)
                <div class="row mx-0">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0">Max Level: {{ $product->max_level }}</p>
                                <p class="mb-0">Max Level: {{ $product->min_level }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($productType)
                <div class="row mx-0">
                    <div class="col">
                        <p class="fs-6 mb-2">Material: <strong>{{ $productType == 0 ? $product->name : $product->product->name. ' | ' .$product->packingType->name. ' | ' .$product->packSize->name  }}</strong></p>
                    </div>
                    <div class="col-auto">
                        <p class="fs-6 mb-2">Code # <strong>{{ $productType == 0 ? $product->code : $product->product->code }}</strong></p>
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th rowspan="2">Date</th>
                            <th rowspan="2">Doc</th>
                            <th colspan="3" class="text-center">Received</th>
                            <th colspan="3" class="text-center">Issued</th>
                            <th colspan="3" class="text-center">Balanced</th>
                        </tr>
                        <tr>
                            <th>QTY</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            <th>QTY</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            <th>QTY</th>
                            <th>Rate</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($stockBinCards)
                            @foreach ($stockBinCards as $stockBinCard)
                                <tr>
                                    <td>{{ $stockBinCard['date'] }}</td>
                                    <td>{{ $stockBinCard['doc'] }}</td>
                                    <td>{{ number_format($stockBinCard['type'] == 'received' ? $stockBinCard['quantity'] : 0, 2) }}</td>
                                    <td>{{ number_format($stockBinCard['type'] == 'received' ? $stockBinCard['unit_price'] : 0, 2) }}</td>
                                    <td>{{ number_format($stockBinCard['type'] == 'received' ? $stockBinCard['total'] : 0, 2) }}</td>
                                    <td>{{ number_format($stockBinCard['type'] == 'issued' ? $stockBinCard['quantity'] : 0, 2) }}</td>
                                    <td>{{ number_format($stockBinCard['type'] == 'issued' ? $stockBinCard['unit_price'] : 0, 2) }}</td>
                                    <td>{{ number_format($stockBinCard['type'] == 'issued' ? $stockBinCard['total'] : 0, 2) }}</td>
                                    <td>{{ $stockBinCard['balance_quantity'] }}</td>
                                    <td>{{ $stockBinCard['balance_unit_price'] }}</td>
                                    <td>{{ $stockBinCard['balance_total'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
            <!-- Print timestamp will be added here -->
            <div id="printTimestampContainer"></div>
        </div>
    </div>
@endsection

<style>
    @media print {
       @page {
           margin: 0;
       }
   
       html, body {
           height: 100%;
           margin: 0;
           padding: 0;
           overflow: hidden;
       }
   
       body * {
           visibility: hidden;
       }
   
       .card-body,
       .card-body * {
           visibility: visible;
       }
   
       .card-body {
           position: fixed;
           left: 0;
           top: 0;
           width: 100%;
       }
   
       .table-primary th {
           background-color: #e3f2fd !important;
           -webkit-print-color-adjust: exact;
           color-adjust: exact;
       }
   }   
</style>