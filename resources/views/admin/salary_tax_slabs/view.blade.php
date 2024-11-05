@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Salary Tax Slab Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('tax-slabs.index') }}">Salary Tax Slabs</a></li>
                    <li class="breadcrumb-item active">Salary Tax Slab Details</li>
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
                            <label for="name">Slab Start</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $taxSlabs->slab_start }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Slab End</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $taxSlabs->slab_end }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Tax Value</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $taxSlabs->tax_value }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name">Country Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $taxSlabs->company->name }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Salary Tax Slabs Update'))
                            <a class="btn btn-primary" href="{{ route('tax-slabs.edit', $taxSlabs->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('tax-slabs.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Salary Tax Slabs Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $taxSlabs->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $taxSlabs->id }}"
                                action="{{ route('tax-slabs.destroy', $taxSlabs->id) }}" method="POST"
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