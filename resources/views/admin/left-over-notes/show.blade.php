@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Left Over Note</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('left-over-notes.index') }}">Left Over Notes</a></li>
                <li class="breadcrumb-item active">View Left Over Note</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="printWithTimestamp()">Print Left Over Note</button>
        </div>
    </div>
    <!-- Print Button -->

    <!-- Card Component -->
    <div class="card">
        <div class="card-body">
            @if ($leftOverNote->is_approved == 1)
                <span class="position-absolute top-0 end-0 ps-2 mt-2 pe-3 bg-success text-light approved-target">{{ $leftOverNote->is_approved == 1 ? 'Approved' : '' }}</span>
            @endif
            <div class="row justify-content-between">
                <div class="col-auto">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{ asset($leftOverNote->company->logo_path ? 'images/company/' . $leftOverNote->company->logo_path : 'images/company/logo.png') }}" class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $leftOverNote->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $leftOverNote->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $leftOverNote->company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end print-header">
                    <h2 class="fs-5 fw-bold">Left Over Note</h2>
                    <p class="fs-6 mb-0">{{ $leftOverNote->code }}</p>
                    <p class="fs-6 mb-0">Date: {{ $leftOverNote->created_at->format('d M, Y') }}</p>
                </div>
            </div>

            <table class="table mt-3">
                <tr>
                    <th>Name</th>
                    <td colspan="3">{{ $leftOverNote->product->name ?? 'N/A' }}</td>
                    <th>SIR</th>
                    <td>{{ $leftOverNote->storeIssueRequisition->code ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td>{{ $leftOverNote->department->name ?? 'N/A' }}</td>
                    <th>Batch #</th>
                    <td>{{ $leftOverNote->batch->batch_no ?? 'N/A' }}</td>
                    <th>DN/GP #</th>
                    <td>{{ $leftOverNote->storeIssueRequisition->dn_gp ?? 'N/A' }}</td>
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
                    @foreach ($leftOverNote->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->rawMaterialItem->code }}</td>
                            <td>{{ $item->rawMaterialItem->name }}</td>
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
                    <span style="font-size: 14px; margin-top: 10px;">Prepared by</span>
                </div>
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Received by</span>
                </div>
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Approved by</span>
                </div>
            </div>
            
            <!-- Print timestamp will be added here -->
            <div id="printTimestampContainer"></div>
        </div>
    </div>
@endsection

<style>
    .print-header{
        margin-top: 10px !important;
    }
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
           background-color: transparent !important;
           -webkit-print-color-adjust: exact;
           color-adjust: exact;
       }

       .approved-target{
            background-color: transparent !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
       }
       .print-header{
            margin-top: 15px !important;
        }
   }
   
</style>