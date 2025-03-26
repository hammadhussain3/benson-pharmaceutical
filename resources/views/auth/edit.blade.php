@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit User</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">user</a></li>
                    <li class="breadcrumb-item active">Edit User</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <!-- Notice the method here: PATCH for update -->
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT') <!-- Use PUT here instead of PATCH -->
                        
                        <div class="form-row row">
                            @role('Superadmin')
                            <div class="col-md-6 mb-3">
                                <label>Select Company </label>
                                <select name="company" id="company" class="js-example-basic-single select2" required onchange="selectEmployee(this.value)">
                                    <option value="">--Select Company--</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}" 
                                            {{ old('company', $employee_details->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endrole
                            <!-- Employee Select Dropdown -->
                            <div class="col-md-6 mb-3">
                                <label>Select Employee</label>
                                <select name="user" id="employee_id" class="js-example-basic-single select2" required onchange="SelectEmployeeDetails(this.value)">
                                    <option value="">--Select Employee--</option>
                                    @php
                                        $selectedCompanyId = old('company', $employee_details->company_id);
                                    @endphp
                                    @foreach ($employees->where('company_id', $selectedCompanyId) as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ $employee->id == old('user', $user->employee_id) ? 'selected' : '' }}>
                                            {{ $employee->code }} - {{ $employee->first_name }} {{ $employee->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Roles Select Dropdown -->
                            <div class="col-md-6 mb-3">
                                <label for="roles">Roles</label>
                                <div class="input-group">
                                    <select class="js-example-basic-multiple" id="roles" required name="role[]" multiple>
                                        <option value="" disabled>Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" 
                                                {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('roles')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password Field (Optional for Edit) -->
                            <div class="col-md-6 mb-3">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control pass-input" placeholder="Change Password">
                                    <span class="input-group-text" id="password_addon">
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                    </span>
                                </div>
                                <small>Leave blank to keep current password.</small>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Full Name Field -->
                            <div class="col-md-6 mb-3">
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" value="{{ old('name', $user->name) }}" required readonly>
                            </div>

                            <!-- Email Field -->
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" value="{{ old('email', $user->email) }}" required readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="branch">Branch</label>
                                <input type="text" id="branch" name="branch" class="form-control" placeholder="Enter Branch" value="{{ old('branch', $branch) }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="department">Department</label>
                                <input type="text" id="department" name="department" class="form-control" placeholder="Enter Department" value="{{ old('department', $department) }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="designation">Designation</label>
                                <input type="text" id="designation" name="designation" class="form-control" placeholder="Enter Designation" value="{{ old('designation', $designation) }}" readonly>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="form-login">
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <a class="btn btn-secondary" href="{{ route('users.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
@endsection
