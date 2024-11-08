@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Dosage Form Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dosage-forms.index') }}">Dosage Forms</a></li>
                    <li class="breadcrumb-item active">Dosage Form Details</li>
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
                            <input type="text" class="form-control" value="{{ $dosageForm->name }}" readonly>
                        </div>
                        @role('Superadmin')
                        <div class="mb-3 col-md-6">
                            <label>Company</label>
                            <input type="text" class="form-control" value="{{ $dosageForm->company->name }}" readonly>
                        </div>
                        @endrole
                        <div class="mb-3 col-md-12">
                            <label>Description</label>
                            <textarea class="form-control" readonly>{{ $dosageForm->description }}</textarea>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            @if(auth()->user()->hasPermission('Dosage Form Update'))
                            <a class="btn btn-primary" href="{{ route('dosage-forms.edit', $dosageForm->id) }}">Update</a>
                            @endif
                            <a class="btn btn-secondary" href="{{ route('dosage-forms.index') }}">Cancel</a>
                        </div>
                        @if(auth()->user()->hasPermission('Dosage Form Delete'))
                        <div class="col-auto">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="confirmDelete('{{ $dosageForm->id }}')">
                                Delete
                            </a>
                            <form id="delete-form-{{ $dosageForm->id }}"
                                action="{{ route('dosage-forms.destroy', $dosageForm->id) }}" method="POST"
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