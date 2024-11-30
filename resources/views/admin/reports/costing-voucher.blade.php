@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Costing Voucher</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Costing Voucher</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Report</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="row justify-content-between mx-0 my-3">
                <div class="col-auto">
                    Batch # {{ $batch->batch_no }}
                </div>
                <div class="col-auto">
                    Code: {{ $batch->product->code }}<br>
                    Name: {{ $batch->product->name }}
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>VNo</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Code</th>
                            <th>Item</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>Debit</th>
                            <th>Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($costingVoucher as $costing)
                            <tr>
                                <td>{{ $costing['code'] }}</td>
                                <td>{{ $costing['doc_type'] }}</td>
                                <td>{{ $costing['date'] }}</td>
                                <td>{{ $costing['product_code'] }}</td>
                                <td>{{ $costing['product_name'] }}</td>
                                <td>{{ $costing['unit'] }}</td>
                                <td>{{ number_format($costing['quantity'], 2) }}</td>
                                <td>{{ number_format($costing['unit_price'], 2) }}</td>
                                <td>{{ $costing['type'] == 'debit' ? number_format($costing['total'], 2) : number_format(0, 2) }}</td>
                                <td>{{ $costing['type'] == 'credit' ? number_format($costing['total'], 2) : number_format(0, 2) }}</td>
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