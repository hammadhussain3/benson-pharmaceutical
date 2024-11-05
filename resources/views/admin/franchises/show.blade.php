@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Franchise Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('franchises.index') }}">Franchises</a></li>
                    <li class="breadcrumb-item active">Franchise Details</li>
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
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $franchise->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $franchise->company_name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Phone</label>
                            <input type="text" class="form-control" value="{{ $franchise->phone }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ $franchise->email }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Country</label>
                            <input type="text" class="form-control" value="{{ $franchise->country->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>City</label>
                            <input type="text" class="form-control" value="{{ $franchise->city->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Address</label>
                            <textarea class="form-control" readonly>{{ $franchise->address }}</textarea>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Payment Type</label>
                            <input type="text" class="form-control" value="{{ $franchise->paymentType->name }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Franchise Update'))
                            <a class="btn btn-primary" href="{{ route('franchises.edit', $franchise->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('franchises.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Franchise Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $franchise->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $franchise->id }}"
                                action="{{ route('franchises.destroy', $franchise->id) }}" method="POST"
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