@extends('admin.layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h4>Product Batches Cost</h4>
        <ul class="breadcrumb">
            <li class="breadcrumb-item active">Product Batches Cost</li>
        </ul>
    </div>
    <div class="text-right">
        <button class="btn btn-primary" onclick="window.print()">Print Report</button>
    </div>
</div>



<div class="card">
    <div class="card-body px-0 pb-0">
        <h5 class="text-center card-title mb-2">Product Batches Cost</h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-primary">
                    <tr>
                        <th rowspan="2">Batch #</th>
                        <th rowspan="2">Packs</th>
                        <th colspan="3" class="text-center">Avg.Cost</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        @php
                            $matchingItem = collect($array)->firstWhere('batch_id', $item['id']);
                        @endphp
                        <tr>
                            <td>{{ $item['batch_no'] }}</td>
                            <td>{{ $item['batch_size'] }}</td>
                            <td>{{ $matchingItem['avgCost'] }}</td>
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
    }
</style>