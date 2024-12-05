@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Payment Voucher</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('payment-vouchers.index') }}">Payment Vouchers</a></li>
                <li class="breadcrumb-item active">View Payment Voucher</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Payment Voucher</button>
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
                            <img src="{{ asset($paymentVoucher->company->logo_path ? 'images/company/' . $paymentVoucher->company->logo_path : 'images/company/logo.png') }}" class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $paymentVoucher->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $paymentVoucher->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $paymentVoucher->company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <h2 class="fs-5 fw-bold">Payment Voucher</h2>
                    <p class="fs-6 mb-0">{{ $paymentVoucher->code }}</p>
                    <p class="fs-6 mb-0">{{ $paymentVoucher->created_at->format('d M, Y') }}</p>
                </div>
            </div>

            <table class="table mt-3">
                <tr>
                    <th>Particular</th>
                    <td>{{ $paymentVoucher->party->name }}</td>
                    <th>Contact Person: </th>
                    <td>{{ $paymentVoucher->party->contact_person_name ?? 'N/A' }}</td>
                    <th>Email: </th>
                    <td>{{ $paymentVoucher->party->contact_person_email ?? $paymentVoucher->party->email }}</td>
                    <th>Phone: </th>
                    <td>{{ $paymentVoucher->party->contact_person_phone ?? $paymentVoucher->party->phone }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td colspan="7">{{ $paymentVoucher->party->address }}</td>
                </tr>
            </table>

            <table class="table table-striped mt-3">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Particular</th>
                        <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentVoucher->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->chartOfAccount->code }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->chartOfAccount->particular }}</td>
                            <td>{{ number_format($item->debit, 2) }}</td>
                            <td>{{ number_format($item->credit, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4"> <strong>Total</strong></th>
                        <th>{{ number_format($paymentVoucher->items->sum('debit'), 2) }}</th>
                        <th>{{ number_format($paymentVoucher->items->sum('credit'), 2) }}</th>
                    </tr>
                </tfoot>
            </table>

            <table class="table mt-3 border">
                <tr>
                    <th>Net:</th>
                    <td class="w-75">{{ number_format($paymentVoucher->total, 2) . $paymentVoucher->currency }}</td>
                </tr>
                <tr>
                    <th>Amount in words:</th>
                    <td class="w-75">
                        <x-amount-in-words :amount="$paymentVoucher->total" />
                    </td>
                </tr>
            </table>

            <div style="display: flex; justify-content: space-around; margin-top: 45px;">
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Prepared by</span>
                </div>
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Checked by</span>
                </div>
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Approved by</span>
                </div>
                <div style="width: 200px; text-align: center;">
                    <hr style="width: 100%;">
                    <span style="font-size: 14px; margin-top: 10px;">Received by</span>
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