@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Distributor Sales Report</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Distributor Sales Report</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Distributor Sales Report</button>
        </div>
    </div>

    <div class="mb-3">
        <form action="{{ route('reports.franchiser-sales') }}" class="row gy-2 gx-3 align-items-end" method="get">
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="from_date">From</label>
                <input type="date" class="form-control" name="from_date" id="from_date" value="{{ $from_date }}">
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="to_date">To</label>
                <input type="date" class="form-control" name="to_date" id="to_date" value="{{ $to_date }}">
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="franchiser">Franchiser</label>
                <select name="franchiser" id="franchiser" class="form-select">
                    @foreach ($parties as $party)
                        <option value="{{ $party->id }}" {{ $party->id == $franchiser->id ? 'selected' : '' }}>{{ $party->name }}</option>
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
            <h5 class="text-center card-title mb-0">Distributor Sales Report - {{ $franchiser->name }}</h5>
            <p class="text-center text-muted">From {{ \Carbon\Carbon::create($from_date)->format('d M, Y') }} to {{ \Carbon\Carbon::create($to_date)->format('d M, Y') }}</p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>Product Group <br> Name</th>
                            @foreach ($all_months as $month)  <!-- Loop through all months to create the table headers -->
                                <th>{{ $month }}</th>
                            @endforeach
                            <th>Total</th> <!-- Total column header -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product_group_sales as $product_group_id => $data)
                            <tr>
                                <td rowspan="{{ count($data['monthly_quantity']) }}">{{ $data['product_group_name'] }}</td>
                                @foreach ($all_months as $month)
                                    @php
                                        // Find the quantity for this month in the current product group
                                        $monthData = collect($data['monthly_quantity'])->firstWhere('month', $month);
                                        $quantity = $monthData ? $monthData['quantity'] : 0;
                                    @endphp
                                    <td>{{ $quantity }}</td>
                                @endforeach
                                <td>
                                    @php
                                        // Calculate the total quantity for this product group
                                        $total_quantity = collect($data['monthly_quantity'])->sum('quantity');
                                    @endphp
                                    {{ $total_quantity }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Total</strong></td>
                            @foreach ($all_months as $month)
                                <td>
                                    <strong>
                                        @php
                                            // Calculate the total for the month (sum of quantities for all product groups)
                                            $monthTotal = 0;
                                            foreach ($product_group_sales as $data) {
                                                $monthData = collect($data['monthly_quantity'])->firstWhere('month', $month);
                                                $monthTotal += $monthData ? $monthData['quantity'] : 0;
                                            }
                                        @endphp
                                        {{ $monthTotal }}
                                    </strong>
                                </td>
                            @endforeach
                            <td>
                                <strong>
                                    @php
                                        // Calculate the overall total (sum of all quantities for all months and product groups)
                                        $overallTotal = 0;
                                        foreach ($product_group_sales as $data) {
                                            $overallTotal += collect($data['monthly_quantity'])->sum('quantity');
                                        }
                                    @endphp
                                    {{ $overallTotal }}
                                </strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>       
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