@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Sale Warranty</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('sale-warranties.index') }}">Sale Warranties</a></li>
                <li class="breadcrumb-item active">View Sale Warranty</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Sale Warranty</button>
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
                            <img src="{{ asset($invoice->company->logo_path ? 'images/company/' . $invoice->company->logo_path : 'images/company/logo.png') }}" class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $invoice->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $invoice->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $invoice->company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <h2 class="mb-0">Warranty</h2>
                    <p class="mb-0"><strong>Ref No:</strong> {{ $invoice->code }}</p>
                    <p class="mb-0"><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</p>
                </div>
            </div>

            <div class="flex-container" style="display: flex; justify-content: space-between;">
                <div style="width: 500px;">
                    <div class="card mb-0">
                        <div class="p-3">
                            <p class="mb-0"><strong>Ship To:</strong> {{ $invoice->party->name }}</p>
                            <p class="mb-0"><strong>Address:</strong> {{ $invoice->party->address }}</p>
                            <p class="mb-0"><strong>Phone:</strong> {{ $invoice->party->contact_person_phone ?? $invoice->party->phone }}
                                <span class="float-end">
                                    <strong>Email:</strong> {{ $invoice->party->contact_person_email ?? $invoice->party->email }}
                                </span>
                            </p>
                            <p class="mb-0"><strong>Contact Person:</strong> {{ $invoice->party->contact_person_name }}</p>
                        </div>
                    </div>
                </div>
                <div style="width: 333px;">
                    <div class="card mb-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Order Number:</strong> {{ $invoice->order_number }}</li>
                            <li class="list-group-item"><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($invoice->order_date)->format('d M, Y') }}</li>
                            <li class="list-group-item"><strong>Shipped Via:</strong> {{ $invoice->shipped_via }}</li>
                        </ul>
                    </div>
                </div>
            </div>            

            <div class="table-responsive">
                <table class="table table-striped mt-3">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Batch #</th>
                            <th>Product <br> Code</th>
                            <th>Products</th>
                            <th>Pack <br> Size</th>
                            <th>MFG. <br> Date</th>
                            <th>Exp. <br> Date</th>
                            <th>Qty. <br> Pack</th>
                            <th>Trans. <br> Code</th>
                            <th>Rate</th>
                            <th>Value</th>
                            <th>Discount</th>
                            <th>Discount <br> Value</th>
                            <th>Sales Tax</th>
                            <th>Inclusive <br> Sales Tax</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->batch?->batch_no }}</td>
                                <td>{{ $item->productVariation?->product?->code }}</td>
                                <td>{{ $item->productVariation?->product?->name }}</td>
                                <td>{{ $item->productVariation?->packSize?->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->batch?->mfg_date)->format('d M, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->batch?->exp_date)->format('d M, Y') }}</td>
                                <td>{{ number_format($item->quantity) }}</td>
                                <td>{{ number_format($item->trans_code) }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                                <td>{{ $item->discount }}{{ $item->discount_type == 'percent' ? '%' : '' }}</td>
                                <td>
                                    {{ number_format(
                                        $item->discount_type == 'percent' 
                                            ? ($item->quantity * $item->unit_price * $item->discount) / 100 
                                            : $item->discount, 
                                        2
                                    ) }}
                                </td>
                                <td>{{ number_format((($item->quantity * $item->unit_price * $item->tax_rate) / 100), 2) }}</td>
                                <td>{{ number_format($item->total_amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <td colspan="6">
                                <x-amount-in-words :amount="$invoice->total_amount" />
                            </td>
                            <td>{{ number_format($invoice->items->sum('quantity')) }}</td>
                            <td>{{ number_format($invoice->items->sum('trans_code')) }}</td>
                            <td>{{ number_format($invoice->items->sum('unit_price'), 2) }}</td>
                            <td>{{ number_format($invoice->items->sum(fn($item) => $item->quantity * $item->unit_price), 2) }}</td>
                            <td></td>
                            <td>
                                {{ number_format(
                                    $invoice->items->sum(fn($item) => 
                                        $item->discount_type == 'percent' 
                                            ? ($item->quantity * $item->unit_price * $item->discount) / 100 
                                            : $item->discount
                                    ), 2
                                ) }}
                            </td>
                            <td>{{ number_format($invoice->items->sum(fn($item) => ($item->quantity * $item->unit_price * $item->tax_rate) / 100), 2) }}</td>
                            <td>{{ number_format($invoice->items->sum('total_amount'), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>                
            </div>
            <div style="margin-top: 15px; font-size: 14px;">
                <strong>Damage Clause:</strong> Claims and replacement of the damage goods shall only be entertained if lodged with undersigned within 2 days of receipt of goods from transporter/carrier
            </div>
            <div style="display: flex; justify-content: space-around; align-items: end; margin-top: 45px;">
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Account Officer</span>
                </div>
                <div style="width: 500px; text-align: center;">
                    <p class="mb-1 fw-bold fs-6">Packing Details</p>
                    <table class="table table-border">
                        <thead>
                            <th>Type of Carton</th>
                            <th>No. of Carton</th>
                            <th>Weight (KG)</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SC-02 <br> SC-90 <br> SC-60</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Authorised Signature <br> Warranter</span>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    @media print {
        @page {
            margin: 0;
            size: landscape;
        }

        body {
            font-size: 12px;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        .card {
            border: none;
            margin: 0;
        }

        .table-primary th {
            background-color: #e3f2fd !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            
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
           font-size: 11px;
       }

       .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 4px 8px;
            font-size: 10px;
        }
    }
</style>