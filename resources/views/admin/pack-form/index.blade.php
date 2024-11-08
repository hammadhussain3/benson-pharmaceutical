@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Pack Form List</h4>
            <h6>Manage your pack form</h6>
        </div>
        @if(auth()->user()->hasPermission('PackForm Create'))
        <div class="page-btn">
            <a href="{{ route('pack-forms.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Pack Form
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
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Description</th>
                            @if(auth()->user()->hasPermission('PackForm View') || auth()->user()->hasPermission('PackForm Update') || auth()->user()->hasPermission('PackForm Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packForms as $packForm)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('pack-forms.show', $packForm->id) }}">{{ $packForm->name }}</a></td>
                                @role('Superadmin')
                                <td>{{ $packForm->company->name }}</td>
                                @endrole
                                <td>{{ $packForm->description }}</td>
                                @if(auth()->user()->hasPermission('PackForm View') || auth()->user()->hasPermission('PackForm Update') || auth()->user()->hasPermission('PackForm Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('PackForm View'))
                                    <a class="me-3" href="{{ route('pack-forms.show', $packForm->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('PackForm Update'))
                                    <a class="me-3" href="{{ route('pack-forms.edit', $packForm->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('PackForm Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $packForm->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $packForm->id }}"
                                        action="{{ route('pack-forms.destroy', $packForm->id) }}" method="POST"
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
