@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Goods Receiving Note</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('goods-receivings.index') }}">Goods Receiving Notes</a></li>
                <li class="breadcrumb-item active">View Goods Receiving Note</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Goods Receiving Note</button>
        </div>
    </div>
    <!-- Print Button -->

    <!-- Card Component -->
    <div class="card">
        <div class="card-body">
            @if ($goodsReceiving->is_approved == 1)
                <span class="position-absolute top-0 end-0 ps-2 mt-2 pe-3 bg-success text-light approved-target">{{ $goodsReceiving->is_approved == 1 ? 'Approved' : '' }}</span>
            @endif
            <div class="row justify-content-between">
                <div class="col-auto">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{ asset($goodsReceiving->company->logo_path ? 'images/company/' . $goodsReceiving->company->logo_path : 'images/company/logo.png') }}" class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $goodsReceiving->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $goodsReceiving->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $goodsReceiving->company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end print-header">
                    <h2 class="fs-5 fw-bold">Goods Receiving Note</h2>
                    <p class="fs-6 mb-0">{{ $goodsReceiving->code }}</p>
                    <p class="fs-6 mb-0">Month: {{ $goodsReceiving->created_at->format('d M, Y') }}</p>
                </div>
            </div>

            <table class="table mt-3">
                <tr>
                    <th>Order Ref</th>
                    <td>{{ $goodsReceiving->invoice->code }}</td>
                    <th>Supplier</th>
                    <td class="w-50">{{ $goodsReceiving->party->name }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $goodsReceiving->invoice->created_at->format('d M, Y') }}</td>
                </tr>
            </table>

            <table class="table table-striped mt-3">
                <thead class="table-primary">
                    <tr class="border-bottom">
                        <th class="border-end align-middle text-center" rowspan="2">#</th>
                        <th class="border-end align-middle text-center" rowspan="2">Code</th>
                        <th class="border-end align-middle text-center" rowspan="2">Description</th>
                        <th class="border-end text-center" colspan="3">Quantity</th>
                        <th class="border-end align-middle text-center" rowspan="2">Unit</th>
                        <th class="border-end text-center" colspan="2">Price (Rs.)</th>
                    </tr>
                    <tr class="border-bottom">
                        <th class="border-end text-center">Ordered</th>
                        <th class="border-end text-center">Pending</th>
                        <th class="border-end text-center">Received</th>
                        <th class="border-end text-center">Per Unit</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>                
                <tbody>
                    @foreach ($goodsReceiving->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product_id ? $item->product->code : $item->rawMaterialItem->code }}</td>
                            <td>{{ $item->product_id ? $item->product->name : $item->rawMaterialItem->name }}</td>
                            <td>{{ $item->quantity_ordered }}</td>
                            <td>{{ $item->quantity_ordered - ($item->quantity_received + $item->balance_receivable) }}</td>
                            <td>{{ $item->balance_receivable }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ number_format($item->unit_price) }}</td>
                            <td>{{ number_format($item->total_amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5"></th>
                        <th colspan="3">Exclusive Tax</th>
                        <td>{{ number_format($goodsReceiving->total_amount - ($goodsReceiving->sales_tax + $goodsReceiving->adv_tax), 2) }}</td>
                    </tr>
                    <tr>
                        <th colspan="5"></th>
                        <th colspan="3">Sales Tax</th>
                        <td>{{ number_format($goodsReceiving->sales_tax, 2) }}</td>
                    </tr>
                    <tr>
                        <th colspan="5"></th>
                        <th colspan="3">Advance Tax</th>
                        <td>{{ number_format($goodsReceiving->adv_tax, 2) }}</td>
                    </tr>
                    <tr>
                        <th colspan="5"></th>
                        <th colspan="3">Tax Inclusice Total</th>
                        <td>{{ number_format($goodsReceiving->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
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
                    <span style="font-size: 14px; margin-top: 10px;">Accepted by</span>
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
            margin-top: 15px !important;
        }
   }
   
</style>