@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Requirement Report</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Requirement Report</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="printWithTimestamp()">Print Requirement Report</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th rowspan="2">Code</th>
                            <th rowspan="2">Item</th>
                            <th rowspan="2">Max.<br>Level</th>
                            <th rowspan="2">Min.<br>Level</th>
                            <th rowspan="2">Current<br>Level</th>
                            <th rowspan="2">Reorder<br>Qty</th>
                            <th colspan="4" class="text-center">In Process</th>
                        </tr>
                        <tr>
                            <th>PO#</th>
                            <th>PO Qty</th>
                            <th>Qty Recv</th>
                            <th>Qty Bal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requirementReport as $requirement)
                            <tr>
                                <td>{{ $requirement->code }}</td>
                                <td>{{ $requirement->name }}</td>
                                <td>{{ $requirement->max_level ?? 0 }}</td>
                                <td>{{ $requirement->min_level ?? 0 }}</td>
                                <td>{{ $requirement->balance() ?? 0 }}</td>
                                <td>{{ $requirement->ordered_quantity ?? 0 }}</td>
                                <td>
                                    @if(isset($requirement->invoice_codes) && is_array($requirement->invoice_codes))
                                        @foreach ($requirement->invoice_codes as $invoice_code)
                                            {{ $invoice_code }}@if(!$loop->last), @endif
                                        @endforeach
                                    @else
                                        No invoices
                                    @endif
                                </td>
                                <td>{{ $requirement->ordered_quantity ?? 0 }}</td>
                                <td>{{ $requirement->received_quantity ?? 0 }}</td>
                                <td>{{ ($requirement->ordered_quantity - $requirement->received_quantity) ?? 0 }}</td>
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