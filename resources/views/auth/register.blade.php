@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add New User</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">user</a></li>
                    <li class="breadcrumb-item active">Add User</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="form-row row">
                            <div class="col-md-6 mb-3">
                                <label>Select Company </label>
                                <select name="company" id="company" class="js-example-basic-single select2" required onchange="selectEmployee(this.value)">
                                    <option value="">--Select Company--</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Select Employee </label>
                                <select name="user" id="employee_id" class="js-example-basic-single select2" required onchange="SelectEmployeeDetails(this.value)">
                                    <option value="">--Select Employee--</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="roles">Roles</label>
                                <div class="input-group">
                                    <select class="form-select" id="roles" required name="role">
                                        <option value="" selected disabled>Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('roles')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control pass-input"
                                        placeholder="Enter your password" required>
                                    <span class="input-group-text" id="password_addon"><span class="fas toggle-password fa-eye-slash"></span></span>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" value="{{ old('name') }}" required readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" value="{{ old('email') }}" required readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="branch">Branch</label>
                                <input type="text" id="branch" name="branch" class="form-control" placeholder="Enter Branch" value="{{ old('branch') }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="department">Department</label>
                                <input type="text" id="department" name="department" class="form-control" placeholder="Enter Department" value="{{ old('branch') }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="designation">Designation</label>
                                <input type="text" id="designation" name="designation" class="form-control" placeholder="Enter Designation" value="{{ old('branch') }}" readonly>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="form-login">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
@endsection
