@extends('admin.layouts.app')

@section('title', 'Packing Types List')

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
                            @if(auth()->user()->hasPermission('PackingType Update'))
                            <th>Action</th>
                            @endif
                            @role('Superadmin')
                            <th>Company</th>
                            @endrole
                            <th>Description</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packing_types as $packing_type)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('packingtypes.view', $packing_type->id) }}">{{ $packing_type->name }}</a></td>
                                @if(auth()->user()->hasPermission('PackingType Update'))
                                <td>
                                    <a class="me-3" href="{{ route('packingtypes.edit', $packing_type->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                </td>
                                @endif
                                @role('Superadmin')
                                <td>{{ $packing_type->company->name }}</td>
                                @endrole
                                <td>{{ $packing_type->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
