@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Pack Size List</h4>
            <h6>Manage your pack size</h6>
        </div>
        @if(auth()->user()->hasPermission('PackSize Create'))
        <div class="page-btn">
            <a href="{{ route('pack_size.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Pack Size
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
                            @if(auth()->user()->hasPermission('PackSize View') || auth()->user()->hasPermission('PackSize Update') || auth()->user()->hasPermission('PackSize Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pack_sizes as $pack_size)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('pack_size.view', $pack_size->id) }}">{{ $pack_size->name }}</a></td>
                                @role('Superadmin')
                                <td>{{ $pack_size->company->name }}</td>
                                @endrole
                                <td>{{ $pack_size->description }}</td>
                                @if(auth()->user()->hasPermission('PackSize View') || auth()->user()->hasPermission('PackSize Update') || auth()->user()->hasPermission('PackSize Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('PackSize View'))
                                    <a class="me-3" href="{{ route('pack_size.view', $pack_size->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('PackSize Update'))
                                    <a class="me-3" href="{{ route('pack_size.edit', $pack_size->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('PackSize Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $pack_size->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $pack_size->id }}"
                                        action="{{ route('pack_size.destroy', $pack_size->id) }}" method="POST"
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
