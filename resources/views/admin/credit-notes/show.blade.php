@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Credit Note</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('credit-notes.index') }}">Credit Notes</a></li>
                <li class="breadcrumb-item active">View Credit Note</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="printWithTimestamp()">Print Credit Note</button>
        </div>
    </div>
    <!-- Print Button -->

    <!-- Card Component -->
    <div class="card">
        <div class="card-body">
            @if ($creditNote->is_approved == 1)
                <span class="position-absolute top-0 end-0 ps-2 mt-2 pe-3 bg-success text-light approved-target">{{ $creditNote->is_approved == 1 ? 'Approved' : '' }}</span>
            @endif
            <div class="row justify-content-between">
                <div class="col-auto">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{ asset($creditNote->company->logo_path ? 'images/company/' . $creditNote->company->logo_path : 'images/company/logo.png') }}" class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $creditNote->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $creditNote->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $creditNote->company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end print-header">
                    <h2 class="fs-5 fw-bold">Credit Note</h2>
                    <p class="fs-6 mb-0">{{ $creditNote->code }}</p>
                    <p class="fs-6 mb-0">{{ $creditNote->created_at->format('d M, Y') }}</p>
                </div>
            </div>

            <table class="table mt-3">
                <tr>
                    <th>Particular</th>
                    <td>{{ $creditNote->party->name }}</td>
                    <th>Contact Person: </th>
                    <td>{{ $creditNote->party->contact_person_name ?? 'N/A' }}</td>
                    <th>Email: </th>
                    <td>{{ $creditNote->party->contact_person_email ?? $creditNote->party->email }}</td>
                    <th>Phone: </th>
                    <td>{{ $creditNote->party->contact_person_phone ?? $creditNote->party->phone }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td colspan="7">{{ $creditNote->party->address }}</td>
                </tr>
            </table>

            <table class="table table-striped mt-3">
                <thead class="table-primary">
                    <tr>
                        <th class="w-75">Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $creditNote->description }}</td>
                        <td>{{ number_format($creditNote->total, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>
                            <x-amount-in-words :amount="$creditNote->total" />
                        </th>
                        <th>{{ number_format($creditNote->total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>

            <table class="table table-striped mt-3">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Particular</th>
                        <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($creditNote->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->chartOfAccount->code }}</td>
                            <td>{{ $item->chartOfAccount->particular }}</td>
                            <td>{{ number_format($item->debit, 2) }}</td>
                            <td>{{ number_format($item->credit, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

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
            
            <!-- Print timestamp will be added here -->
            <div id="printTimestampContainer"></div>
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
           background-color: transparent !important;
           -webkit-print-color-adjust: exact;
           color-adjust: exact;
       }

       .approved-target{
            background-color: transparent !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
       }
       .print-header{
            margin-top: 15px !important;
        }
   }
</style>