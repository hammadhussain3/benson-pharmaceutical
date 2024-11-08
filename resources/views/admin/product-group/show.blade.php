@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Product Group Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('product-groups.index') }}">Product Group</a></li>
                    <li class="breadcrumb-item active">Product Group Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row row">
                        @role('Superadmin')
                        <div class="mb-3 col-md-6">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $productGroup->company->name ?? 'N/A' }}" readonly>
                        </div>
                        @endrole

                        <div class="mb-3 col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $productGroup->name ?? 'N/A' }}" readonly>
                        </div>

                        
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('ProductGroup Update'))
                            <a class="btn btn-primary" href="{{ route('product-groups.edit', $productGroup->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('product-groups.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('ProductGroup Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $productGroup->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $productGroup->id }}"
                                action="{{ route('product-groups.destroy', $productGroup->id) }}" method="POST"
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