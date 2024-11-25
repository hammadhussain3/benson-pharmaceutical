@extends('admin.layouts.app')

@section('content')
<style>
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        border: 1px solid black;
        text-align: center;
        vertical-align: middle;
        padding: 8px;
    }
</style>
    <div class="page-header">
        <div class="page-title">
            <h4>Current Balance Report</h4>
            <ul class="breadcrumb">
                
                <li class="breadcrumb-item active">View Current Balance Report</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Current Balance Report</button>
        </div>
    </div>
    <!-- Print Button -->


    <!-- Card Component -->
    <div class="card">
        <div class="card-body">
       

            <table class="table table-striped mt-3">
                <thead class="table-primary">
                    <tr>
                        <th rowspan="2">Code</th>
                        <th rowspan="2">Item Description</th>
                        <th colspan="4">Balance</th>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Rate</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stocks as $stock)
                        <tr>
                            <td>{{ $stock->product->code }}</td>
                            <td>{{ $stock->product->name }}</td>
                            <td>{{ $stock->available_quantity }}</td>
                            <td>{{ $stock->unit }}</td>
                            <td>{{ $stock->rate }}</td>
                            <td>{{ $stock->value }}</td>
                        </tr>
                    @endforeach
                    
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
            
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