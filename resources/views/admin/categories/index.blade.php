@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Categories List</h4>
            <h6>Manage your categories</h6>
        </div>
        @if(auth()->user()->hasPermission('Category Create'))
        <div class="page-btn">
            <a href="{{ route('categories.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add Category
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
                            <th>Prefix</th>
                            <th>Description</th>
                            @if(auth()->user()->hasPermission('Category View') || auth()->user()->hasPermission('Category Update') || auth()->user()->hasPermission('Category Delete'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a class="link-primary" href="{{ route('categories.view', $category->id) }}">{{ $category->name }}</a></td>
                                @role('Superadmin')
                                <td>{{ $category->company->name }}</td>
                                @endrole
                                <td>{{ $category->prefix }}</td>
                                <td>{{ $category->description }}</td>
                                @if(auth()->user()->hasPermission('Category View') || auth()->user()->hasPermission('Category Update') || auth()->user()->hasPermission('Category Delete'))
                                <td>
                                    @if(auth()->user()->hasPermission('Category View'))
                                    <a class="me-3" href="{{ route('categories.view', $category->id) }}">
                                        <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="View">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Category Update'))
                                    <a class="me-3" href="{{ route('categories.edit', $category->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('Category Delete'))
                                    <a class="confirm-text" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ $category->id }}')">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                    <form id="delete-form-{{ $category->id }}"
                                        action="{{ route('categories.destroy', $category->id) }}" method="POST"
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
