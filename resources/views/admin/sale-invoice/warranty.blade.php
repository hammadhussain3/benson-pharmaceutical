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
            <button class="btn btn-primary" onclick="printWithTimestamp()">Print Sale Warranty</button>
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
                            <p class="mb-0"><strong>Address:</strong> {{ $invoice->party->address }}, {{ $invoice->party->city->name }}, {{ $invoice->party->country->name }}</p>
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
                            <th>Exclusive <br> Sales Tax</th>
                            <th>Sales Tax</th>
                            <th>Inclusive <br> Sales Tax</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->items as $item)
                            @php                              
                                $total = $item->quantity * $item->unit_price;
                                $discountAmount = ($total * 10) / 100;
                                $discountAmountVar = $item->discount_type == 'percent'
                                    ? ($total * $item->discount / 100)
                                    : $item->discount;
                                $transCode = $total - $discountAmountVar + ((($total - $discountAmountVar) * $item->tax_rate) / 100);
                                $amountAfterDiscount = $total - $discountAmount;
                                $taxAmount = ($amountAfterDiscount * $item->tax_rate) / 100;
                                $finalAmount = $amountAfterDiscount + $taxAmount;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->batch?->batch_no }}</td>
                                <td>{{ $item->productVariation?->code }}</td>
                                <td>
                                    {{ $item->productVariation?->product?->brand_name }}
                                    {{ $item->productVariation?->strength }}
                                    {{ $item->productVariation?->packingType?->name }}
                                </td>
                                <td>{{ $item->productVariation?->packSize?->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->batch?->mfg_date)->format('d M, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->batch?->exp_date)->format('d M, Y') }}</td>
                                <td>{{ number_format($item->quantity) }}</td>
                                <td>{{ number_format($transCode, 2) }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ number_format($total, 2) }}</td>
                                <td>10%</td>
                                <td>{{ number_format($discountAmount, 2) }}</td>
                                <td>{{ number_format($amountAfterDiscount, 2) }}</td>
                                <td>{{ number_format($taxAmount, 2) }}</td>
                                <td>{{ number_format($finalAmount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php
                            $totals = $invoice->items->reduce(function ($carry, $item) {
                                $total = $item->quantity * $item->unit_price;

                                $discountAmount = ($total * 10) / 100;
                                $discountAmountVar = $item->discount_type == 'percent'
                                    ? ($total * $item->discount / 100)
                                    : $item->discount;

                                $transCode = $total - $discountAmountVar + ((($total - $discountAmountVar) * $item->tax_rate) / 100);
                                $amountAfterDiscount = $total - $discountAmount;
                                $taxAmount = ($amountAfterDiscount * $item->tax_rate) / 100;
                                $finalAmount = $amountAfterDiscount + $taxAmount;

                                return [
                                    'quantity' => $carry['quantity'] + $item->quantity,
                                    'transCode' => $carry['transCode'] + $transCode,
                                    'total' => $carry['total'] + $total,
                                    'discount' => $carry['discount'] + $discountAmount,
                                    'afterDiscount' => $carry['afterDiscount'] + $amountAfterDiscount,
                                    'tax' => $carry['tax'] + $taxAmount,
                                    'final' => $carry['final'] + $finalAmount,
                                ];
                            }, ['quantity' => 0, 'transCode' => 0, 'total' => 0, 'discount' => 0, 'afterDiscount' => 0, 'tax' => 0, 'final' => 0]);
                        @endphp
                        <tr>
                            <th>Total</th>
                            <td colspan="6">
                                <x-amount-in-words :amount="$totals['final']" />
                            </td>
                            <td>{{ number_format($totals['quantity']) }}</td>
                            <td>{{ number_format($totals['transCode'], 2) }}</td>
                            <td></td>
                            <td>{{ number_format($totals['total'], 2) }}</td>
                            <td></td>
                            <td>{{ number_format($totals['discount'], 2) }}</td>
                            <td>{{ number_format($totals['afterDiscount'], 2) }}</td>
                            <td>{{ number_format($totals['tax'], 2) }}</td>
                            <td>{{ number_format($totals['final'], 2) }}</td>
                        </tr>
                    </tfoot>
                </table>                
            </div>
            <div style="margin-top: 15px; font-size: 14px;">
                <p class="mb-1"><strong>Damage Clause:</strong> Claims and replacement of the damage goods shall only be entertained if lodged with undersigned within 2 days of receipt of goods from transporter/carrier</p>
                <p class="fw-bold text-center mb-1">WARRANTY FORM 2A (See Rules 19 & 30) <br> UnderSection 23(1)(i) of the Drugs Act 1976</p>
                <p>I. Rahat Ali Khan, being a person resident in Pakistan carrying on business at No. 03, Main Road, National Industrial Zone (Chamber Industrial Area), Rawat, Rawalpindi, under the name of M/s. Benson Pharmaceuticals, do hereby give this warranty that the drugs herein above described as sold/manufactured by us specified and contained in the bill of sale, Invoice/delivery challan, bill of lading or other document describing the goods referred to herein do not contravene in any way the provisions of section 23 of the drugs act 1976.</p>
            </div>
            <div style="display: flex; justify-content: space-around; align-items: end; margin-top: 20px;">
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Account Officer</span>
                </div>
                <div style="width: 500px; text-align: center;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="py-1 fw-bold fs-6 text-center border-bottom" colspan="3">Packing Details</th>
                            </tr>
                            <tr>
                                <th class="py-1">Type of Carton</th>
                                <th class="py-1">No. of Carton</th>
                                <th class="py-1">Weight (KG)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-1">SC-02</td>
                                <td class="py-1"></td>
                                <td class="py-1"></td>
                            </tr>
                            <tr>
                                <td class="py-1">SC-90</td>
                                <td class="py-1"></td>
                                <td class="py-1"></td>
                            </tr>
                            <tr>
                                <td class="py-1">SC-60</td>
                                <td class="py-1"></td>
                                <td class="py-1"></td>
                            </tr>
                            <tr>
                                <td class="py-1">Total</td>
                                <td class="py-1"></td>
                                <td class="py-1"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Authorised Signature <br> Warranter</span>
                </div>
            </div>
            
            <!-- Print timestamp will be added here -->
            <div id="printTimestampContainer"></div>
        </div>
    </div>
@endsection

<style>
    .table-bordered, .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6;
        border-collapse: collapse;
    }
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
            background-color: transparent !important;
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
           background-color: transparent !important;
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