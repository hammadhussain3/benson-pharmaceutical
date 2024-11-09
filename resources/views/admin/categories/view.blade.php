@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Category Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active">Category Details</li>
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
                            <input type="text" class="form-control" value="{{ $category->company->name ?? 'N/A' }}" readonly>
                        </div>
                        @endrole

                        <div class="mb-3 col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $category->name ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>Prefix</label>
                            <input type="text" class="form-control" value="{{ $category->prefix ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>Description</label>
                            <textarea class="form-control" readonly>{{ $category->description ?? 'N/A' }}</textarea>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Category Update'))
                            <a class="btn btn-primary" href="{{ route('categories.edit', $category->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('categories.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Category Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $category->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $category->id }}"
                                action="{{ route('categories.destroy', $category->id) }}" method="POST"
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