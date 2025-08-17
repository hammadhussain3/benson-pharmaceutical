@extends('admin.layouts.app')

@section('content')
    <style>
        table.table-bordered th,
        table.table-bordered td {
            border: 1px solid #e9ecef !important;
        }

        table.table-bordered {
            border: 1px solid #e9ecef !important;
            border-collapse: collapse !important;
        }
    </style>

    <div class="page-header">
        <div class="page-title">
            <h4>{{ $invoice->type == 'purchase' ? 'Purchase Order' : ($invoice->type == 'sale' ? 'Sale Invoice' : ($invoice->type == 'quotation' ? 'Quotation' : '')) }}
            </h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('purchase-invoices.index') }}">Invoices</a></li>
                <li class="breadcrumb-item active">View
                    {{ $invoice->type == 'purchase' ? 'Purchase Order' : ($invoice->type == 'sale' ? 'Sale Invoice' : ($invoice->type == 'quotation' ? 'Quotation' : '')) }}
                </li>
            </ul>
        </div>
        <div class="d-flex align-items-center gap-2">
            {{-- Previous Button --}}
            @if($previous)
                <a href="{{ route('purchase-invoices.show', $previous->id) }}" class="btn btn-outline-secondary">
                    &laquo; Previous
                </a>
            @else
                <button class="btn btn-outline-secondary" disabled>&laquo; Previous</button>
            @endif

            {{-- Next Button --}}
            @if($next)
                <a href="{{ route('purchase-invoices.show', $next->id) }}" class="btn btn-outline-secondary">
                    Next &raquo;
                </a>
            @else
                <button class="btn btn-outline-secondary" disabled>Next &raquo;</button>
            @endif

            {{-- Edit Button --}}
            <a href="{{ route('purchase-invoices.edit', $invoice->id) }}" class="btn btn-light">
                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
            </a>

            {{-- Print Button --}}
            <!-- <button class="btn btn-light" onclick="window.print()" data-approved ="{{ $invoice->is_approved }}" id="print-button">
                <img src="{{ asset('assets/img/icons/printer.svg') }}" alt="Edit">
            </button> -->
            <button class="btn btn-light" onclick="checkApprovalAndPrint(this)" data-approved="{{ $invoice->is_approved }}" id="print-button">
                <img src="{{ asset('assets/img/icons/printer.svg') }}" alt="Print">
            </button>


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
                            <img src="{{ asset($invoice->company->logo_path ? 'images/company/' . $invoice->company->logo_path : 'images/company/logo.png') }}"
                                class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $invoice->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $invoice->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $invoice->company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end print-header">
                    <h2>{{ $invoice->type == 'purchase' ? 'Purchase Order' : ($invoice->type == 'sale' ? 'Sale Invoice' : ($invoice->type == 'quotation' ? 'Quotation' : '')) }}
                    </h2>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between;">
                <div style="width: 233px;">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Ref No:</strong> {{ $invoice->code }}</li>
                            <li class="list-group-item"><strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</li>
                        </ul>
                    </div>
                </div>
                <div style="width: 766px;">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div style="width: 333px;">
                                        <strong>Required Date:</strong>
                                        {{ \Carbon\Carbon::parse($invoice->required_date)->format('d M, Y') }}
                                    </div>
                                    <div class="col border-start border-end"><strong>Urgent</strong></div>
                                    <div class="col d-flex align-items-center">
                                        {!! $invoice->is_urgent == '1' ? '<i class="fa fa-check"></i>' : '' !!}
                                    </div>
                                    <div class="col border-start border-end"><strong>Ordinary</strong></div>
                                    <div class="col">{{ $invoice->is_urgent == '0' ? '*' : '' }}</div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <strong>{{ $invoice->type == 'purchase' ? 'Supplier' : ($invoice->type == 'sale' || $invoice->type == 'quotation' ? 'Franchise' : '') }}:</strong>
                                {{ optional($invoice->party)->name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Item Code</th>
                            <th rowspan="2">Description</th>
                            <th rowspan="2">Current <br>Balance</th>
                            <th rowspan="2">Min. <br>Level</th>
                            <th rowspan="2">Max. <br>Level</th>
                            <th rowspan="2">Quantity <br>Required</th>
                            <th rowspan="2">Price</th>
                            <th rowspan="2">Unit</th>
                            <th colspan="2">Last Purchase</th>
                            <th colspan="2">In-Process</th>
                            <th rowspan="2">Consumption <br>6 Month</th>
                        </tr>
                        <tr>
                            <th>Ref.</th>
                            <th>Price</th>
                            <th>PO List</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->code }}</td>
                                <td @if ($item->description) style="white-space: inherit;" @endif>
                                    <strong class="float-start">{{ $item->title }}</strong>
                                    @if ($item->description)
                                        <br>{{ $item->description }}
                                    @endif
                                </td>
                                <td>{{ $item->balance }}</td>
                                <td>{{ $item->min_level }}</td>
                                <td>{{ $item->max_level }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->unit_price }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>{{ $item->lp_ref }}</td>
                                <td>{{ $item->lp_price }}</td>
                                <td style="white-space: inherit;">{{ $item->ip_po_list }}</td>
                                <td>{{ $item->ip_quantity }}</td>
                                <td>{{ $item->consumption_6_months }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                        <tr>
                            <th colspan="5" class="text-right"> <strong>Sub Total</strong></th>
                            <th>{{ number_format($invoice->items_cost_without_tax, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right"> <strong>Tax Rate ({{ $invoice->invoice_tax_rate
                                    }}%):</strong></th>
                            <th>{{ number_format($invoice->total_invoice_tax, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right"> <strong>Discount ({{ $invoice->discount_type }}):</strong>
                            </th>
                            <th>{{ number_format($invoice->discount, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right"> <strong>Total Amount:</strong></th>
                            <td>{{ number_format($invoice->total_amount, 2) }}</td>
                        </tr>
                    </tfoot> --}}
                </table>
            </div>
            @if ($invoice->note)
                <div style="width: 100%;">
                    <div style="margin-bottom: 15px; margin-top: 15px; font-size: 14px;">
                        <strong>Note:</strong> {{ $invoice->note }}
                    </div>
                </div>
            @endif
            <div class="signature-section" style="margin-top: 45px;">
                <div style="display: flex; justify-content: space-around; align-items: end;">
                    <div style="width: 266px; text-align: center;">
                        <span style="font-size: 14px; font-weight: bold;">{{ $invoice->createdBy->name ?? null }}</span>
                        <hr style="width: 100%; margin: 5px 0px;">
                        <span style="font-size: 14px;">Raised by</span>
                    </div>
                    <div style="width: 266px; text-align: center;">
                        <hr style="width: 100%; margin: 5px 0px;">
                        <span style="font-size: 14px;">Checked by Dept. Head</span>
                    </div>
                    <div style="width: 266px; text-align: center;">
                        <span style="font-size: 14px; font-weight: bold;">
                            {{ $invoice->approvedBy->name ?? null }}
                            ({{ $invoice->is_approved == 1 ? 'Approved' : 'Draft' }})
                        </span>
                        <hr style="width: 100%; margin: 5px 0px;">
                        <span style="font-size: 14px;">Approved by: Cheif Executive</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .print-header {
        margin-top: 10px !important;
    }

    @media print {
        .signature-section {
            position: fixed;
            bottom: 10px;
            left: 0;
            width: 100%;
        }

        @page {
            margin: 0;
            size: landscape;
        }

        html,
        body {
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

        table.table-bordered {
            font-size: 10px !important;
        }

        .approved-target {
            background-color: #e3f2fd !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .print-header {
            margin-top: 15px !important;
        }
    }
</style>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function checkApprovalAndPrint(button) {
        var isApproved = button.getAttribute('data-approved');
        if(isApproved == '1' || isApproved.toLowerCase() == 'yes' || isApproved.toLowerCase() == 'true') {
            window.print();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Not Approved!',
                text: 'This purchase order is not approved yet.',
                confirmButtonText: 'OK'
            });
        }
    }
</script>