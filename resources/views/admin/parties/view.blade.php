@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Party Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('parties.index') }}">Parties</a></li>
                    <li class="breadcrumb-item active">Party Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        <div class="mb-3 col-md-6">
                            <label>Party Name</label>
                            <input type="text" class="form-control" value="{{ $party->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Party Code</label>
                            <input type="text" class="form-control" value="{{ $party->code ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Country</label>
                            <input type="text" class="form-control" value="{{ $party->country->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>City</label>
                            <input type="text" class="form-control" value="{{ $party->city->name ?? 'N/A' }}" readonly>
                        </div>
                        @role('Superadmin')
                        <div class="mb-3 col-md-12">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $party->company->name ?? 'N/A' }}" readonly>
                        </div>
                        @endrole
                        <div class="mb-3 col-md-6">
                            <label>Contact Person Name</label>
                            <input type="text" class="form-control" value="{{ $party->contact_person_name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Contact Person Phone</label>
                            <input type="text" class="form-control" value="{{ $party->contact_person_phone ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Contact Person Email</label>
                            <input type="text" class="form-control" value="{{ $party->contact_person_email ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Phone</label>
                            <input type="text" class="form-control" value="{{ $party->phone ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ $party->email ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Address</label>
                            <textarea class="form-control" readonly>{{ $party->address ?? 'N/A' }}</textarea>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Payment Type</label>
                            <input type="text" class="form-control" value="{{ $party->paymentType->name ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>Is Supplier?</label>
                            <input type="text" class="form-control" value="{{ $party->is_supplier == '1' ? 'Yes' : 'No' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Is Distributor?</label>
                            <input type="text" class="form-control" value="{{ $party->is_distributor == '1' ? 'Yes' : 'No' }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Parties Update'))
                            <a class="btn btn-primary" href="{{ route('parties.edit', $party->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('parties.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Parties Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $party->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $party->id }}"
                                action="{{ route('parties.destroy', $party->id) }}" method="POST"
                                style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection