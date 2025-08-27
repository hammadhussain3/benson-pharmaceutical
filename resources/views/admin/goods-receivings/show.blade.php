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
        <div class="d-flex align-items-center gap-2">
            {{-- Previous Button --}}
            @if($previous)
                <a href="{{ route('goods-receivings.show', $previous->id) }}" class="btn btn-outline-secondary">
                    &laquo; Previous
                </a>
            @else
                <button class="btn btn-outline-secondary" disabled>&laquo; Previous</button>
            @endif

            {{-- Next Button --}}
            @if($next)
                <a href="{{ route('goods-receivings.show', $next->id) }}" class="btn btn-outline-secondary">
                    Next &raquo;
                </a>
            @else
                <button class="btn btn-outline-secondary" disabled>Next &raquo;</button>
            @endif

            {{-- Print Button --}}
            <button class="btn btn-light" onclick="printGRN()">
                <img src="{{ asset('assets/img/icons/printer.svg') }}" alt="Print">
            </button>
        </div>
    </div>

    <!-- Card Component -->
    <div class="card">
        <div class="card-body">
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

            <table class="table mt-2">
                <tr>
                    <th>Order Ref</th>
                    <td>{{ $goodsReceiving->invoice->code }}</td>
                    <th>Supplier</th>
                    <td class="w-50">{{ $goodsReceiving->supplier_name }} ({{ $goodsReceiving->supplier_code }})</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $goodsReceiving->invoice->created_at->format('d M, Y') }}</td>
                </tr>
            </table>

            <table class="table table-striped table-bordered mt-2">
                <thead class="table-primary">
                    <tr class="border-bottom">
                        <th class="border-end align-middle text-center" rowspan="2">#</th>
                        <th class="border-end align-middle text-center" rowspan="2">Code</th>
                        <th class="border-end align-middle text-center" rowspan="2" style="width: 40%">Description</th>
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
                            <td>{{ $item->code }}</td>
                            <td class="description-cell">
                                Batch# {{ $item->batch }}<br>
                                MFG: {{ $item->mfg_date ? \Carbon\Carbon::parse($item->mfg_date)->format('d/m/Y') : 'N/A' }}<br>
                                EXP: {{ $item->exp_date ? \Carbon\Carbon::parse($item->exp_date)->format('d/m/Y') : 'N/A' }}<br>
                                {{ $item->description }}
                            </td>
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
                        <th colspan="6"></th>
                        <th colspan="2">Total</th>
                        <td>{{ number_format($goodsReceiving->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Vendor Bills Summary -->
            @if(isset($goodsReceiving->vendor_bills) && count($goodsReceiving->vendor_bills) > 0)
                <div class="mt-4">
                    <h6 class="fw-bold">Vendor Bills Summary</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Vendor Bill No</th>
                                    <th>Bill Date</th>
                                    <th>Amount (Rs.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($goodsReceiving->vendor_bills as $vendorBill)
                                    <tr>
                                        <td>
                                            @if(isset($goodsReceiving->items[$vendorBill->item_index]))
                                                {{ Str::limit($goodsReceiving->items[$vendorBill->item_index]->description, 50) }}
                                            @else
                                                Item {{ $vendorBill->item_index + 1 }}
                                            @endif
                                        </td>
                                        <td>{{ $vendorBill->bill_no }}</td>
                                        <td>{{ $vendorBill->bill_date ? \Carbon\Carbon::parse($vendorBill->bill_date)->format('d/m/Y') : 'N/A' }}</td>
                                        <td>{{ number_format($vendorBill->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-light">
                                    <th colspan="3" class="text-end">Total Vendor Bills Amount:</th>
                                    <th>{{ number_format($goodsReceiving->vendor_bills->sum('amount'), 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endif

            <div class="signature-section" style="margin-top: 25px;">
                <div style="display: flex; justify-content: space-around; align-items: end;">
                    <div style="width: 180px; text-align: center;">
                        {{ $goodsReceiving->createdBy->name ?? null }}
                        <hr style="width: 100%; margin: 3px 0px;">
                        <span style="font-size: 14px;">Raised by</span>
                    </div>
                    <div style="width: 180px; text-align: center;">
                        <hr style="width: 100%; margin: 3px 0px;">
                        <span style="font-size: 14px;">Received by</span>
                    </div>
                    <div style="width: 180px; text-align: center;">
                        <hr style="width: 100%; margin: 3px 0px;">
                        <span style="font-size: 14px;">Accepted by</span>
                    </div>
                    <div style="width: 180px; text-align: center;">
                        <span style="font-size: 14px; font-weight: bold;">
                            @if($goodsReceiving->is_approved == 1)
                                Approved
                            @else
                                Draft
                            @endif
                        </span>
                        <hr style="width: 100%; margin: 3px 0px;">
                        <span style="font-size: 14px;">Status</span>
                    </div>
                </div>
            </div>
            
            <!-- Print timestamp will be added here -->
            <div id="printTimestampContainer"></div>
        </div>
    </div>

    <script>
        function printGRN() {
            // Add timestamp to footer before printing
            const timestampContainer = document.getElementById('printTimestampContainer');
            const timestampDiv = document.createElement('div');
            timestampDiv.style.cssText = 'text-align: center; margin-top: 20px; font-size: 14px; color: #666;';
            timestampDiv.innerHTML = '<strong>Printed on:</strong> ' + new Date().toLocaleString('en-GB');
            
            // Clear any existing timestamp and add new one
            timestampContainer.innerHTML = '';
            timestampContainer.appendChild(timestampDiv);
            
            // Print
            window.print();
            
            // Remove timestamp after printing
            setTimeout(() => {
                timestampContainer.innerHTML = '';
            }, 1000);
        }
    </script>
@endsection

<style>
    .print-header{
        margin-top: 5px !important;
    }
    /* Ensure long descriptions wrap inside the cell */
    .table.table-striped td.description-cell{
        white-space: normal !important;
        word-break: break-word;
        overflow-wrap: anywhere;
    }
    /* Stronger borders for the items grid */
    .table.table-striped.table-bordered{
        border-collapse: collapse;
    }
    .table.table-striped.table-bordered th,
    .table.table-striped.table-bordered td{
        border: 1px solid #dee2e6 !important;
    }
    @media print {
        .signature-section {
            position: fixed;
            bottom: 5px;
            left: 0;
            width: 100%;
        }
       @page {
           margin: 5mm;
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
       /* Darker borders on print for clarity */
       .table.table-striped.table-bordered th,
       .table.table-striped.table-bordered td{
           border: 1px solid #000 !important;
       }
   }
   
</style>