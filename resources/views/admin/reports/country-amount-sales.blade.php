@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Distributors Sales Report Amount Wise</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Distributors Sales Report Amount Wise</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="printWithTimestamp()">Print Distributors Sales Report</button>
        </div>
    </div>

    <div class="mb-3">
        <form action="{{ route('reports.country-amount-sales') }}" class="row gy-2 gx-3 align-items-end" method="get">
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="from_date">From</label>
                <input type="date" class="form-control" name="from_date" id="from_date" value="{{ $from_date }}">
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="to_date">To</label>
                <input type="date" class="form-control" name="to_date" id="to_date" value="{{ $to_date }}">
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="country">Countries</label>
                <select name="country" id="country" class="form-select">
                    @foreach ($countries as $coun)
                        <option value="{{ $coun->id }}" {{ $coun->id == $country->id ? 'selected' : '' }}>{{ $coun->name }}</option>
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
            <h5 class="text-center card-title mb-0">Distributors Sales Report Amount Wise - {{ $country->name }}</h5>
            <p class="text-center text-muted">From {{ \Carbon\Carbon::create($from_date)->format('d M, Y') }} to {{ \Carbon\Carbon::create($to_date)->format('d M, Y') }}</p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>Franchiser Name</th>
                            @foreach ($all_product_groups as $product_group) <!-- Loop through all unique product groups -->
                                <th>{{ $product_group->name }}</th>
                            @endforeach
                            <th>Total</th> <!-- Total column header -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($franchiser_sales as $franchiser)
                            <tr>
                                <td>{{ $franchiser['franchiser_name'] }}</td>
                                @php
                                    $franchiserTotal = 0;
                                @endphp
                                @foreach ($all_product_groups as $product_group)
                                    @php
                                        // Find the quantity for this product group in the current franchiser sales data
                                        $productGroupData = collect($franchiser['franchiser_sales'])->firstWhere('product_group_id', $product_group->id);
                                        $amount = $productGroupData ? $productGroupData['amount'] : 0;
                                        $franchiserTotal += $amount;
                                    @endphp
                                    <td>{{ $amount }}</td>
                                @endforeach
                                <td>{{ $franchiserTotal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Total</strong></td>
                            @php
                                $grandTotals = [];
                            @endphp
                            @foreach ($all_product_groups as $product_group)
                                @php
                                    $total = 0;
                                    foreach ($franchiser_sales as $franchiser) {
                                        $sales = collect($franchiser['franchiser_sales'])->firstWhere('product_group_id', $product_group->id);
                                        $total += $sales ? $sales['amount'] : 0;
                                    }
                                    $grandTotals[] = $total;
                                @endphp
                                <td><strong>{{ $total }}</strong></td>
                            @endforeach
                            <td><strong>{{ array_sum($grandTotals) }}</strong></td>
                        </tr>
                    </tfoot>
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
            size: landscape;
        }

        body {
            font-size: 12px;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        .card {
            border: none;
            margin: 0;
        }

        .table-primary th {
            background-color: #e3f2fd !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            
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
           font-size: 11px;
       }

       .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 4px 8px;
            font-size: 10px;
        }
    }
</style>