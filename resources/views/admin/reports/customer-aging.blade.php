@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Customer Aging Report</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Customer Aging Report</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">Print Customer Aging Report</button>
        </div>
    </div>

    <div class="mb-3">
        <form action="{{ route('reports.customer-aging') }}" class="row gy-2 gx-3 align-items-end" method="get">
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="from_date">From</label>
                <input type="date" class="form-control" name="from_date" id="from_date" value="{{ $from_date }}">
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="to_date">To</label>
                <input type="date" class="form-control" name="to_date" id="to_date" value="{{ $to_date }}">
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="party">Parties</label>
                <select name="party" id="party" class="form-select">
                    @foreach ($partyList as $singleParty)
                        <option value="{{ $singleParty->id }}" {{ $singleParty->id == $party->id ? 'selected' : '' }}>{{ $singleParty->name }}</option>
                    @endforeach                    
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>            
        </form>
    </div>

    <div class="card">
        <div class="card-body px-0 pb-0">
            <h5 class="text-center card-title mb-0">Customer Aging Report</h5>
            <p class="text-center text-muted">From {{ \Carbon\Carbon::create($from_date)->format('d M, Y') }} to {{ \Carbon\Carbon::create($to_date)->format('d M, Y') }}</p>
            <div class="border m-2 p-2 col-md-6">
                <p class="mb-1">{{ $party->code. ' ' .$party->name }}</p>
                <p class="mb-1">{{ $party->address }}</p>
                <p class="mb-1">Phone: {{ $party->contact_person_phone ?? $party->phone }} <span class="float-end">Email: {{ $party->contact_person_email ?? $party->email }}</span></p>
                <p class="mb-1">Contact Person Name: {{ $party->contact_person_name }}</p>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>Invoice <br> No.</th>
                            <th>Date</th>
                            <th>Invoice <br> Amount</th>
                            <th>Payable <br> Balance</th>
                            <th>Aging <br> Days</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->code }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</td>
                                <td>{{ number_format($invoice->total_amount, 2) }}</td>
                                <td>{{ number_format($invoice->due_amount, 2) }}</td>
                                <td>
                                    @php
                                      // Parse the payment_deadline and calculate the difference in days
                                      $deadline = \Carbon\Carbon::parse($invoice->payment_deadline);
                                      $now = \Carbon\Carbon::now();
                                  
                                      // Ensure the deadline is a valid date and calculate the difference
                                      $diffInDays = $deadline->isValid() ? $now->diffInDays($deadline, false) : 0;
                                      // Round the number of days to avoid decimals
                                      $diffInDays = round($diffInDays);
                                    @endphp
                                
                                    @if($diffInDays < 0)
                                      <span class="text-danger">{{ abs($diffInDays) }}<i class="fa-solid fa-arrow-up"></i></span>
                                    @else
                                        <span class="text-success">{{ abs($diffInDays) }}<i class="fa-solid fa-arrow-down"></i></span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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