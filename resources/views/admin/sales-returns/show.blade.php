@extends('layouts.app')

@section('template_title')
    {{ $salesReturn->name ?? __('Show') . " " . __('Sales Return') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Sales Return</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('sales-returns.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Code:</strong>
                                    {{ $salesReturn->code }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Party Id:</strong>
                                    {{ $salesReturn->party_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Invoice Tax Rate:</strong>
                                    {{ $salesReturn->invoice_tax_rate }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Total Invoice Tax:</strong>
                                    {{ $salesReturn->total_invoice_tax }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Discount Type:</strong>
                                    {{ $salesReturn->discount_type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Discount:</strong>
                                    {{ $salesReturn->discount }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Company Id:</strong>
                                    {{ $salesReturn->company_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Created By:</strong>
                                    {{ $salesReturn->created_by }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Updated By:</strong>
                                    {{ $salesReturn->updated_by }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
