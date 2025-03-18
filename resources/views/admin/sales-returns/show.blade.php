@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Sales Return</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('sales-returns.index') }}">Sales Returns</a></li>
                <li class="breadcrumb-item active">View Sales Return</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Sales Return</button>
        </div>
    </div>
    <!-- Print Button -->

    <!-- Card Component -->
    <div class="card">
        <div class="card-body">
            @if ($salesReturn->is_approved == 1)
                <span class="position-absolute top-0 end-0 ps-2 mt-2 pe-3 bg-success text-light approved-target">{{ $salesReturn->is_approved == 1 ? 'Approved' : '' }}</span>
            @endif
            <div class="row justify-content-between">
                <div class="col-auto">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{ asset($salesReturn->company->logo_path ? 'images/company/' . $salesReturn->company->logo_path : 'images/company/logo.png') }}" class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $salesReturn->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $salesReturn->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $salesReturn->company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end print-header">
                    <h2 class="mb-0">Sales Return</h2>
                    <p class="mb-0"><strong>Ref No:</strong> {{ $salesReturn->code }}</p>
                    <p class="mb-0"><strong>Date:</strong> {{ \Carbon\Carbon::parse($salesReturn->created_at)->format('d M, Y') }}</p>
                </div>
            </div>

            <div class="flex-container" style="display: flex; justify-content: space-between;">
                <div style="width: 500px;">
                    <div class="card mb-0">
                        <div class="p-3">
                            <p class="mb-0"><strong>Ship To:</strong> {{ $salesReturn->party->name }}</p>
                            <p class="mb-0"><strong>Address:</strong> {{ $salesReturn->party->address }}</p>
                            <p class="mb-0"><strong>Phone:</strong> {{ $salesReturn->party->contact_person_phone ?? $salesReturn->party->phone }}
                                <span class="float-end">
                                    <strong>Email:</strong> {{ $salesReturn->party->contact_person_email ?? $salesReturn->party->email }}
                                </span>
                            </p>
                            <p class="mb-0"><strong>Contact Person:</strong> {{ $salesReturn->party->contact_person_name }}</p>
                        </div>
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
                            <th>Rate</th>
                            <th>Value</th>
                            <th>Discount</th>
                            <th>Discount <br> Value</th>
                            <th>Sales Tax</th>
                            <th>Inclusive <br> Sales Tax</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salesReturn->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->batch?->batch_no }}</td>
                                <td>{{ $item->productVariation?->product?->code }}</td>
                                <td>{{ $item->productVariation?->product?->name }}</td>
                                <td>{{ $item->productVariation?->packSize?->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->batch?->mfg_date)->format('d M, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->batch?->exp_date)->format('d M, Y') }}</td>
                                <td>{{ number_format($item->quantity) }}</td>
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
                                <x-amount-in-words :amount="$salesReturn->total_amount" />
                            </td>
                            <td>{{ number_format($salesReturn->items->sum('quantity')) }}</td>
                            <td>{{ number_format($salesReturn->items->sum('unit_price'), 2) }}</td>
                            <td>{{ number_format($salesReturn->items->sum(fn($item) => $item->quantity * $item->unit_price), 2) }}</td>
                            <td></td>
                            <td>
                                {{ number_format(
                                    $salesReturn->items->sum(fn($item) => 
                                        $item->discount_type == 'percent' 
                                            ? ($item->quantity * $item->unit_price * $item->discount) / 100 
                                            : $item->discount
                                    ), 2
                                ) }}
                            </td>
                            <td>{{ number_format($salesReturn->items->sum(fn($item) => ($item->quantity * $item->unit_price * $item->tax_rate) / 100), 2) }}</td>
                            <td>{{ number_format($salesReturn->items->sum('total_amount'), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>                
            </div>
            <div style="display: flex; justify-content: space-around; margin-top: 45px;">
                <div style="width: 166px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Account Officer</span>
                </div>
                <div style="width: 166px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Accepted By <br> Q.A Manager</span>
                </div>
                <div style="width: 166px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Received By <br> W.H Manager</span>
                </div>
                <div style="width: 166px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Reviewed By <br> Director Production</span>
                </div>
                <div style="width: 166px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Authorised Signature <br> Warranter</span>
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