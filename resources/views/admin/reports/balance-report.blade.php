@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Current Balance Report</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Current Balance Report</li>
            </ul>
        </div>
        {{-- <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Report</button>
        </div> --}}
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-input">
                        <a class="btn btn-searchset">
                            <img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img">
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table datanew dataTable no-footer table-striped">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Item Description</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Rate</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stocks as $stock)
                            <tr>
                                <td>{{ $stock['code'] ?? 'N/A' }}</td>
                                <td>{{ $stock['name'] ?? 'N/A' }}</td>
                                <td>{{ $stock['balance'] ?? 0 }}</td>
                                <td>{{ $stock['item_unit'] ?? 'N/A' }}</td>
                                <td>{{ number_format($stock['unit_price'] ?? 0, 2) }}</td>
                                <td>{{ number_format(($stock['balance'] ?? 0) * ($stock['unit_price'] ?? 0), 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

{{-- <style>
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
</style> --}}