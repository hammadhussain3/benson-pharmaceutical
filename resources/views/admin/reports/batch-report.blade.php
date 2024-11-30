@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Batch Wise Current Ballance Report</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Batch Wise Current Ballance Report</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Report</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th rowspan="2">Code</th>
                            <th rowspan="2">Description</th>
                            <th colspan="4" class="text-center">Balance</th>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Rate</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($batchBalanceReport as $balanceReport)
                            <tr>
                                <td>{{ $balanceReport['code'] }}</td>
                                <td>{{ $balanceReport['name'] }}</td>
                                <td>{{ number_format($balanceReport['quantity'], 2) }}</td>
                                <td>{{ $balanceReport['unit'] }}</td>
                                <td>{{ number_format($balanceReport['unit_price'], 2) }}</td>
                                <td>{{ number_format($balanceReport['unit_price'] * $balanceReport['quantity'], 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    @foreach ($balanceReport['batches'] as $batch)
                                        <div class="d-flex mb-2">
                                            <div class="col">
                                                <a href="{{ route('reports.costing-voucher', $batch['batch_id']) }}">Batch # {{ $batch['batch_code'] }}</a>
                                            </div>
                                            <div class="col">
                                                Bal QTY # {{ $batch['batch_balance'] }}
                                            </div>
                                            <div class="col">
                                                Mfg {{ $batch['mfg'] }}
                                            </div>
                                            <div class="col">
                                                Exp {{ $batch['exp'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
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