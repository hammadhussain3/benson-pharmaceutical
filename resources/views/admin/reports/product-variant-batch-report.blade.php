@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Product Batches Cost</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Product Batches Cost</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="printWithTimestamp()">Print Report</button>
        </div>
    </div>

    <div class="mb-3">
        <form action="{{ route('reports.batch-report') }}" class="row gy-2 gx-3 align-items-end" method="get">
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="product">Products</label>
                <select name="product" id="product" class="js-example-basic-single select2">
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ $product->id == $finalProduct->id ? 'selected' : '' }}>{{ $product->product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>            
        </form>
    </div>


    <div class="card">
        <div class="card-body px-0 pb-0">
            <h5 class="text-center card-title mb-2">Product Batches Cost</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>Batch #</th>
                            <th>Packs</th>
                            <th>Avg.Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            @php
                                $matchingItem = collect($array)->firstWhere('batch_id', $item['id']);
                            @endphp
                            <tr>
                                <td>{{ $item['batch_no'] }}</td>
                                <td>{{ $item['batch_size'] }}</td>
                                <td>{{ number_format($matchingItem['avgCost'], 2) }}</td>
                            </tr>
                        @endforeach

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

        html,
        body {
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
           background-color: transparent !important;
           -webkit-print-color-adjust: exact;
           color-adjust: exact;
       }
    }
</style>