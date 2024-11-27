@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Finished Goods Receiving Note</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('finished-goods-receivings.index') }}">Finished Goods Receiving Notes</a></li>
                <li class="breadcrumb-item active">View Finished Goods Receiving Note</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Finished Goods Receiving Note</button>
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
                            <img src="{{ asset($finishedGoodsReceiving->company->logo_path ? 'images/company/' . $finishedGoodsReceiving->company->logo_path : 'images/company/logo.png') }}" class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $finishedGoodsReceiving->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $finishedGoodsReceiving->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $finishedGoodsReceiving->company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <h2 class="fs-5 fw-bold">Finished Goods Receiving Note</h2>
                    <p class="fs-6 mb-0">{{ $finishedGoodsReceiving->code }}</p>
                    <p class="fs-6 mb-0">Month: {{ $finishedGoodsReceiving->created_at->format('d M, Y') }}</p>
                </div>
            </div>

            <table class="table mt-3">
                <tr>
                    <th>Batch No</th>
                    <td>{{ $finishedGoodsReceiving->batch->batch_no }}</td>
                    <th>Particular</th>
                    <td class="w-50">{{ $finishedGoodsReceiving->product->code. '(' .$finishedGoodsReceiving->product->name. ')' }}</td>
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
                    @foreach ($finishedGoodsReceiving->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->productVariation->product->code }}</td>
                            <td>{{ $item->productVariation->product->name. ' | ' .$item->productVariation->packingType->name. ' | ' .$item->productVariation->packSize->name }}</td>
                            <td>{{ $item->quantity_received }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ number_format($item->unit_price) }}</td>
                            <td>{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 15px;">
                <div style="text-align: center;">
                    <h5>Marketing Certificate</h5>
                </div>
                <ol style="list-style: decimal; padding-left: 20px;">
                    <li style="margin-top: 15px;">
                        It is certified that the above product has been formulated and tested in our supervision in accordance with the pharmacopial requirements of the product and is fit for human consumption, hence released for marketing.
                        <div style="display: flex; justify-content: space-between; margin-top: 40px;">
                            <div style="width: 266px; text-align: center;">
                                <hr style="width: 100%;">
                                <span style="font-size: 14px; margin-top: 10px;">Production Manager (Sign/Stamp)</span>
                            </div>
                            <div style="width: 266px; text-align: center;">
                                <hr style="width: 100%;">
                                <span style="font-size: 14px; margin-top: 10px;">Quality Control Manager (Sign/Stamp)</span>
                            </div>
                        </div>
                    </li>
                    <li style="margin-top: 15px;">
                        It is certified that the above product has been formulated, tested and packed in my supervision while complying with the requirements of CGMP, hence released for marketing.
                        <div style="display: flex; justify-content: center; margin-top: 40px;">
                            <div style="width: 266px; text-align: center;">
                                <hr style="width: 100%;">
                                <span style="font-size: 14px; margin-top: 10px;">Quality Assurance Manager (Sign/Stamp)</span>
                            </div>
                        </div>
                    </li>
                    <li style="margin-top: 15px;">
                        Based on above recommendations product is released for sale in market
                        <div style="display: flex; justify-content: space-around; margin-top: 40px;">
                            <div style="width: 266px; text-align: center;">
                                <hr style="width: 100%;">
                                <span style="font-size: 14px; margin-top: 10px;">Received by Store Keeper</span>
                            </div>
                            <div style="width: 266px; text-align: center;">
                                <hr style="width: 100%;">
                                <span style="font-size: 14px; margin-top: 10px;">Accepted by W.H Manager</span>
                            </div>
                            <div style="width: 266px; text-align: center;">
                                <hr style="width: 100%;">
                                <span style="font-size: 14px; margin-top: 10px;">Approved by Cheif Executive</span>
                            </div>
                        </div>
                    </li>
                </ol>
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