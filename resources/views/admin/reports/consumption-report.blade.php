@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Consumption Report</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Consumption Report</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Consumption Report</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Consumption</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consumptionReport as $consumption)
                            <tr>
                                <td>{{ $consumption->code }}</td>
                                <td>{{ $consumption->name }}</td>
                                <td>{{ $consumption->unit }}</td>
                                <td>{{ number_format($consumption->total_quantity, 2) }}</td>
                                <td>{{ number_format($consumption->average_unit_price, 2) }}</td>
                                <td>{{ number_format($consumption->average_unit_price * $consumption->total_quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
   
       table,
       table * {
           visibility: visible;
       }
   
       table {
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