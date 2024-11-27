@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Rejection Return Note</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('rejection-return-notes.index') }}">Rejection Return Notes</a></li>
                <li class="breadcrumb-item active">View Rejection Return Note</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Rejection Return Note</button>
        </div>
    </div>
    <!-- Print Button -->

    <!-- Card Component -->
    <div class="card">
        <div class="card-body">

            <div class="row justify-content-between">
                <div class="col-auto">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{ asset($rejectionReturnNote->company->logo_path ? 'images/company/' . $rejectionReturnNote->company->logo_path : 'images/company/logo.png') }}" class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $rejectionReturnNote->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $rejectionReturnNote->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $rejectionReturnNote->company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <h2 class="fs-5 fw-bold">Rejection Return Note</h2>
                    <p class="fs-6 mb-0">{{ $rejectionReturnNote->code }}</p>
                    <p class="fs-6 mb-0">Date: {{ $rejectionReturnNote->created_at->format('d M, Y') }}</p>
                </div>
            </div>

            <table class="table mt-3">
                <tr>
                    <th>Supplier</th>
                    <td>{{ $rejectionReturnNote->party->name ?? 'N/A' }}</td>
                    <th>PO #</th>
                    <td>{{ $rejectionReturnNote->invoice->code ?? 'N/A' }}</td>
                    <th>Batch #</th>
                    <td>{{ $rejectionReturnNote->batch->batch_no ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Code</th>
                    <td>{{ $rejectionReturnNote->party->code ?? 'N/A' }}</td>
                    <th>Supplier Bill #</th>
                    <td>{{ $rejectionReturnNote->supplier_bill_no ?? 'N/A' }}</td>
                    <th>DN/GP #</th>
                    <td>{{ $rejectionReturnNote->storeIssueRequisition->dn_gp ?? 'N/A' }}</td>
                </tr>
            </table>

            <table class="table table-striped mt-3">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Remarks</th>
                    </tr>
                </thead>                
                <tbody>
                    @foreach ($rejectionReturnNote->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->code ?? $item->rawMaterialItem->code }}</td>
                            <td>{{ $item->product->name ?? $item->rawMaterialItem->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ number_format($item->unit_price) }}</td>
                            <td>{{ number_format($item->total, 2) }}</td>
                            <td>{{ $item->remarks }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="display: flex; justify-content: space-around; margin-top: 45px;">
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Raised by</span>
                </div>
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Received by</span>
                </div>
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Reject by</span>
                </div>
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Approved by</span>
                </div>
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