@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Packing Type List</h4>
            <h6>Manage your packing types</h6>
        </div>
        @if(auth()->user()->hasPermission('PackingType Create'))
        <div class="page-btn">
            <a href="{{ route('packingtypes.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Packing Type
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
                            @if(auth()->user()->hasPermission('PackingType View') || auth()->user()->hasPermission('PackingType Update') || auth()->user()->hasPermission('PackingType Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packing_types as $packing_type)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('packingtypes.view', $packing_type->id) }}">{{ $packing_type->name }}</a></td>
                                @role('Superadmin')
                                <td>{{ $packing_type->company->name }}</td>
                                @endrole
                                <td>{{ $packing_type->description }}</td>
                                @if(auth()->user()->hasPermission('PackingType View') || auth()->user()->hasPermission('PackingType Update') || auth()->user()->hasPermission('PackingType Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('PackingType View'))
                                    <a class="me-3" href="{{ route('packingtypes.view', $packing_type->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('PackingType Update'))
                                    <a class="me-3" href="{{ route('packingtypes.edit', $packing_type->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('PackingType Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $packing_type->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $packing_type->id }}"
                                        action="{{ route('packingtypes.destroy', $packing_type->id) }}" method="POST"
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
