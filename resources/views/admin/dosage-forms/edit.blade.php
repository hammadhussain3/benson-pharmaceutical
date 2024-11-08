@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Dosage Form</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dosage-forms.index') }}">Dosage Forms</a></li>
                    <li class="breadcrumb-item active">Edit Dosage Form</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dosage-forms.update', $dosageForm->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $dosageForm->name) }}" placeholder="Dosage Form Name" required>
                            </div>
                            @role('Superadmin')
                            <div class="mb-3 col-md-6">
                                <label for="company_id">Company</label>
                                <select name="company" id="company_id" class="js-example-basic-single select2" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $company->id == old('company', $dosageForm->company_id) ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a company.</div>
                            </div>
                            @else
                                <input type="hidden" name="company" value="{{ $dosageForm->company_id }}">
                            @endrole
                            <div class="mb-3 col-md-12">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Description...">{{ old('description', $dosageForm->description) }}</textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('dosage-forms.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection