@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit Role</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active">Edit Role</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" class="form-control" name="guard_name" value="\App\Models\User">
                        <div class="form-row row">
                            <div class="mb-3 col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $role->name) }}" required>
                                <div class="invalid-feedback">Please provide a unique role.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAllPermissions" onclick="toggleAll(this)">
                                <label class="form-check-label" for="selectAllPermissions">
                                    Administration
                                </label>
                            </div>
                            <div class="invalid-feedback">Please provide a unique role.</div>
                        </div>
                        <div class="table-responsive mb-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Modules</th>
                                        <th>List</th>
                                        <th>create</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Employee</td>
                                        <td><input class="form-check-input" type="checkbox" value="1" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(1) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="2" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(2) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="3" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(3) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="4" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(4) ? 'checked' : '' }}></td>
                                        <td><input class="form-check-input" type="checkbox" value="5" name="permissions[]" id="permissions" {{ $role_has_permissions->pluck('permission_id')->contains(5) ? 'checked' : '' }}></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('roles.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleAll(selectAll) {
            // Get all checkboxes in the table
            const checkboxes = document.querySelectorAll('table input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked; // Set each checkbox to the state of the "Select All" checkbox
            });
        }
    </script> 
@endsection
