@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Purchase Requisition List</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Purchase Requisition List</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Purchase Requisition List</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>PO#</th>
                            <th>Date</th>
                            <th>Req Del Date</th>
                            <th>Status</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseRequisitions as $purchaseRequisitions)
                            <tr>
                                <td>{{ $purchaseRequisitions->code }}</td>
                                <td>{{ \Carbon\Carbon::parse($purchaseRequisitions->invoice_date)->format('d M, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($purchaseRequisitions->required_date)->format('d M, Y') }}</td>
                                <td>{{ $purchaseRequisitions->status }}</td>
                                <td>
                                    @foreach ($purchaseRequisitions->items as $item)
                                        {!! $item->item_code. ' ' .$item->item_name. '<br>QTY=' .$item->product_quantity. ' RECV=' .$item->received_quantity !!}<br>
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