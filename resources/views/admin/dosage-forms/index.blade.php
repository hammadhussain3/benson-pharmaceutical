@extends('admin.layouts.app')

@section('title', 'Dosage Forms List')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Dosage Form List</h4>
            <h6>Manage your Dosage Forms</h6>
        </div>
        @if(auth()->user()->hasPermission('Dosage Form Create'))
        <div class="page-btn">
            <a href="{{ route('dosage-forms.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Dosage Form
            </a>
        </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-input">
                        <a class="btn btn-searchset">
                            <img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img">
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table datanew dataTable no-footer table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            @if(auth()->user()->hasPermission('Dosage Form View') || auth()->user()->hasPermission('Dosage Form Update') || auth()->user()->hasPermission('Dosage Form Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dosageForms as $dosageForm)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a class="link-primary" href="{{ route('dosage-forms.show', $dosageForm->id) }}">{{ $dosageForm->name }}</a></td>
                                <td>{{ \Illuminate\Support\Str::words($dosageForm->description, 4, '...') }}</td>
                                @role('Superadmin')
                                <td>{{ $dosageForm->company->name ?? 'N/A' }}</td>
                                @endrole
                                @if(auth()->user()->hasPermission('Dosage Form View') || auth()->user()->hasPermission('Dosage Form Update') || auth()->user()->hasPermission('Dosage Form Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Dosage Form View'))
                                    <a class="me-3" href="{{ route('dosage-forms.show', $dosageForm->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Dosage Form Update'))
                                    <a class="me-3" href="{{ route('dosage-forms.edit', $dosageForm->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Dosage Form Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $dosageForm->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $dosageForm->id }}"
                                        action="{{ route('dosage-forms.destroy', $dosageForm->id) }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection