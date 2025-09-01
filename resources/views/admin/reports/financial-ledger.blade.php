@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Financial Ledger Report</h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Financial Ledger Report</li>
            </ul>
        </div>
        <div class="text-right">
            <button class="btn btn-primary" onclick="printWithTimestamp()">Print Financial Ledger Report</button>
        </div>
    </div>

    <div class="mb-3">
        <form action="{{ route('reports.financial-ledger') }}" class="row gy-2 gx-3 align-items-end" method="get">
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="from_date">From</label>
                <input type="date" class="form-control" name="from_date" id="from_date" value="{{ $from_date }}">
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="to_date">To</label>
                <input type="date" class="form-control" name="to_date" id="to_date" value="{{ $to_date }}">
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="status">Franchisers</label>
                <select name="status" id="status" class="form-select">
                    @foreach ($parties as $party)
                        <option value="{{ $party->id }}" {{ $party->id == $franchiser->id ? 'selected' : '' }}>{{ $party->name }}</option>
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
            <h5 class="text-center card-title mb-0">Financial Ledger Report</h5>
            <p class="text-center text-muted">From {{ \Carbon\Carbon::create($from_date)->format('d M, Y') }} to {{ \Carbon\Carbon::create($to_date)->format('d M, Y') }}</p>
            <div class="border-top border-bottom p-2">
                <p class="text-muted">{{ $franchiser->code. ' ' .$franchiser->name }}</p>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>Date</th>
                            <th>VR</th>
                            <th>Payment <br> Method</th>
                            <th>Particular</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($financial_ledger as $report)
                            <tr>
                                <td>{{ $report['created_at'] }}</td>
                                <td>{{ $report['vr'] }}</td>
                                <td>{{ $report['payment_method'] }}</td>
                                <td>{{ $report['particular'] }}</td>
                                <td>{{ $report['type'] == 'debit' ? $report['amount'] : '' }}</td>
                                <td>{{ $report['type'] == 'credit' ? $report['amount'] : '' }}</td>
                                <td>{{ $report['balance'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
            <!-- Print timestamp will be added here -->
            <div id="printTimestampContainer"></div>
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
           background-color: transparent !important;
           -webkit-print-color-adjust: exact;
           color-adjust: exact;
       }
       
       /* Ensure timestamp container is visible in print */
       #printTimestampContainer {
           visibility: visible !important;
           display: block !important;
           page-break-inside: avoid !important;
       }
       
       #printTimestamp {
           visibility: visible !important;
           display: block !important;
           text-align: center !important;
           margin-top: 20px !important;
           font-size: 14px !important;
           color: #666 !important;
           page-break-inside: avoid !important;
       }
   }   
</style>