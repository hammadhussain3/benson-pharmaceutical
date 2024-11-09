@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Pack Size Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('pack_size.index') }}">Pack Size</a></li>
                    <li class="breadcrumb-item active">Pack Size Details</li>
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
                            <input type="text" class="form-control" value="{{ $pack_size->company->name ?? 'N/A' }}" readonly>
                        </div>
                        @endrole

                        <div class="mb-3 col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $pack_size->name ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-12">
                            <label>Description</label>
                            <textarea class="form-control" readonly>{{ $pack_size->description ?? 'N/A' }}</textarea>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('PackSize Update'))
                            <a class="btn btn-primary" href="{{ route('pack_size.edit', $pack_size->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('pack_size.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('PackSize Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $pack_size->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $pack_size->id }}"
                                action="{{ route('pack_size.destroy', $pack_size->id) }}" method="POST"
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