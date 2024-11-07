@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Packing Type Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Packing Types</a></li>
                    <li class="breadcrumb-item active">Packing Type Details</li>
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
                            <input type="text" class="form-control" value="{{ $packing_type->company->name ?? 'N/A' }}" readonly>
                        </div>
                        @endrole

                        <div class="mb-3 col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $packing_type->name ?? 'N/A' }}" readonly>
                        </div>


                        <div class="mb-3 col-md-6">
                            <label>Description</label>
                            <input type="text" class="form-control" value="{{ $packing_type->description ?? 'N/A' }}" readonly>
                        </div>

                        
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('PackingType Update'))
                            <a class="btn btn-primary" href="{{ route('packingtypes.edit', $packing_type->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('packingtypes.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('PackingType Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $packing_type->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $packing_type->id }}"
                                action="{{ route('packingtypes.destroy', $packing_type->id) }}" method="POST"
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