@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Store Issue Requisition</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('store-issue-requisitions.index') }}">Store Issue Requisitions</a></li>
                <li class="breadcrumb-item active">View Store Issue Requisition</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Store Issue Requisition</button>
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
                            <img src="{{ asset($requisition->company->logo_path ? 'images/company/' . $requisition->company->logo_path : 'images/company/logo.png') }}" class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $requisition->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $requisition->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $requisition->company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <h2 class="fs-5 fw-bold">Store Issue Requisition</h2>
                    <p class="fs-6 mb-0">{{ $requisition->code }}</p>
                    <p class="fs-6 mb-0">Month: {{ $requisition->created_at->format('d M, Y') }}</p>
                </div>
            </div>

            <table class="table mt-3">
                <tr>
                    <th>Name / Product</th>
                    <td colspan="4">{{ $requisition->product->name ?? $requisition->chart_of_account->particular }}</td>
                </tr>
                <tr>
                    <th>Batch No</th>
                    <td>{{ $requisition->batch->batch_no ?? 'N/A' }}</td>
                    <th>Batch Size</th>
                    <td>{{ $requisition->batch->batch_size ?? 'N/A' }}</td>
                    <th class="w-50"></th>
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
                    </tr>
                </thead>                
                <tbody>
                    @foreach ($requisition->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->code ?? $item->raw_material_item->code ?? $item->product_variation->product->name. ' | ' .$item->product_variation->packingType->name. ' | ' .$item->product_variation->packSize->name }}</td>
                            <td>{{ $item->product->name ?? $item->raw_material_item->name ?? $item->product_variation->product->code }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ number_format($item->unit_price) }}</td>
                            <td>{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="display: flex; justify-content: space-around; margin-top: 45px;">
                <div style="width: 166px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Raised by</span>
                </div>
                <div style="width: 166px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Authorised by</span>
                </div>
                <div style="width: 166px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Issued by</span>
                </div>
                <div style="width: 166px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Received by</span>
                </div>
                <div style="width: 166px; text-align: center;">
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