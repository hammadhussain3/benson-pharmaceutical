@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>{{ $invoice->type == 'purchase' ? 'Purchase Requisition' : ($invoice->type == 'sale' ? 'Sale Invoice' : ($invoice->type == 'quotation' ? 'Quotation' : '')) }}</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('purchase-invoices.index') }}">Invoices</a></li>
                <li class="breadcrumb-item active">View {{ $invoice->type == 'purchase' ? 'Purchase Requisition' : ($invoice->type == 'sale' ? 'Sale Invoice' : ($invoice->type == 'quotation' ? 'Quotation' : '')) }}</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print {{ $invoice->type == 'purchase' ? 'Purchase Requisition' : ($invoice->type == 'sale' ? 'Sale Invoice' : ($invoice->type == 'quotation' ? 'Quotation' : '')) }}</button>
        </div>
    </div>
    <!-- Print Button -->

    <!-- Card Component -->
    <div class="card">
        <div class="card-body">
            @if ($invoice->is_approved == 1)
                <span class="position-absolute top-0 end-0 ps-2 mt-2 pe-3 bg-success text-light approved-target">{{ $invoice->is_approved == 1 ? 'Approved' : '' }}</span>
            @endif
            <div class="row justify-content-between">
                <div class="col-auto">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{ asset($invoice->company->logo_path ? 'images/company/' . $invoice->company->logo_path : 'images/company/logo.png') }}" class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $invoice->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $invoice->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $invoice->company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end mt-2 print-header">
                    <h2>{{ $invoice->type == 'purchase' ? 'Purchase Requisition' : ($invoice->type == 'sale' ? 'Sale Invoice' : ($invoice->type == 'quotation' ? 'Quotation' : '')) }}</h2>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between;">
                <div style="width: 233px;">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Ref No:</strong> {{ $invoice->code }}</li>
                            <li class="list-group-item"><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</li>
                        </ul>
                    </div>
                </div>
                <div style="width: 766px;">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div style="width: 333px;">
                                        <strong>Required Date:</strong> {{ \Carbon\Carbon::parse($invoice->required_date)->format('d M, Y') }}
                                    </div>
                                    <div class="col border-start border-end"><strong>Urgent</strong></div>
                                    <div class="col">{{ $invoice->is_urgent == '1' ? '*' : '' }}</div>
                                    <div class="col border-start border-end"><strong>Ordinary</strong></div>
                                    <div class="col">{{ $invoice->is_urgent == '0' ? '*' : '' }}</div>
                                </div>
                            </li>
                            <li class="list-group-item"><strong>{{ $invoice->type == 'purchase' ? 'Supplier' : ($invoice->type == 'sale' || $invoice->type == 'quotation' ? 'Franchise' : '') }}:</strong> {{ $invoice->party->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <table class="table table-striped mt-3">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ number_format($item->unit_price) }}</td>
                            <td>{{ number_format($item->total_amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right"> <strong>Sub Total</strong></th>
                        <th>{{ number_format($invoice->items_cost_without_tax, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-right"> <strong>Tax Rate ({{ $invoice->invoice_tax_rate }}%):</strong></th>
                        <th>{{ number_format($invoice->total_invoice_tax, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-right"> <strong>Discount ({{ $invoice->discount_type }}):</strong></th>
                        <th>{{ number_format($invoice->discount, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-right"> <strong>Total Amount:</strong></th>
                        <td>{{ number_format($invoice->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
            <div style="display: flex; justify-content: space-around; margin-top: 45px;">
                <div style="width: 266px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Raised by</span>
                </div>
                <div style="width: 266px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Checked by Dept. Head</span>
                </div>
                <div style="width: 266px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Approved by: Cheif Executive</span>
                </div>
            </div>
            <div style="margin-top: 15px; font-size: 14px;">
                <strong>Note:</strong> {{ $invoice->note }}
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

       .approved-target{
            background-color: #e3f2fd !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
       }
       .print-header{
            margin-top: 10px !important;
       }
   }
   
   </style>