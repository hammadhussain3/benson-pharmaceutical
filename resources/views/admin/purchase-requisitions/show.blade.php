@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Manual Purchase Requisition</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('purchase-requisitions.index') }}">Manual Purchase Requisitions</a></li>
                <li class="breadcrumb-item active">View Manual Purchase Requisition</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Manual Purchase Requisition</button>
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
                            <img src="{{ asset($purchaseRequisition->company->logo_path ? 'images/company/' . $purchaseRequisition->company->logo_path : 'images/company/logo.png') }}" class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $purchaseRequisition->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $purchaseRequisition->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $purchaseRequisition->company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <h2>Manual Purchase Requisition</h2>
                </div>
            </div>
       
            <table class="table mt-3">
                <tr>
                    <th>PR No.</th>
                    <td>{{ $purchaseRequisition->code }}</td>
                    <th>Date</th>
                    <td>{{ $purchaseRequisition->created_at->format('Y-m-d') }}</td>
                    <th>Required Date</th>
                    <td>{{ \Carbon\Carbon::parse($purchaseRequisition->required_date)->format('Y-m-d') }}</td>
                </tr>
                <tr>
                    <th>Supplier</th>
                    <td colspan="3">{{ $purchaseRequisition->supplier->name }}</td>
                </tr>
            </table>

            <table class="table table-striped mt-3">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchaseRequisition->purchaseRequisitionItems as $key => $purchaseRequisitionItem)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $purchaseRequisitionItem->name }}</td>
                            <td>{{ $purchaseRequisitionItem->quantity }}</td>
                            <td>{{ $purchaseRequisitionItem->unit }}</td>
                            <td>{{ $purchaseRequisitionItem->price }}</td>
                            <td>{{ $purchaseRequisitionItem->amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right"> <strong>Total</strong></th>
                        <th>{{ number_format($purchaseRequisition->total_amount, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
            @if ($purchaseRequisition->special_instructions)
                <div style="margin-top: 15px; font-size: 14px;">
                    <strong>Note:</strong> {{ $purchaseRequisition->special_instructions }}
                </div>
            @endif
            <div style="display: flex; justify-content: space-around; margin-top: 45px;">
                <div style="width: 266px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Prepared by</span>
                </div>
                <div style="width: 266px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Checked by</span>
                </div>
                <div style="width: 266px; text-align: center;">
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