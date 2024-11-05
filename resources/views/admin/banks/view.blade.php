@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Bank Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('banks.index') }}">Banks</a></li>
                    <li class="breadcrumb-item active">Bank Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        <div class="mb-3 col-md-12">
                            <label for="name">Bank Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $bank->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Bank Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $bank->acronym ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Bank Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $bank->country->name ?? 'N/A' }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Bank Update'))
                            <a class="btn btn-primary" href="{{ route('banks.edit', $bank->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('banks.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Bank Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $bank->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $bank->id }}"
                                action="{{ route('banks.destroy', $bank->id) }}" method="POST"
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