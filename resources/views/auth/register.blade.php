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
                            <div class="col-md-4 mb-3">
                                <label for="name">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="name-addon"><img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img"></span>
                                    <input type="text" id="name" name="name" class="form-control"
                                        placeholder="Enter your full name" value="{{ old('name') }}" required
                                        autofocus>
                                </div>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="email">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="email-addon"><img src="{{ asset('assets/img/icons/mail.svg') }}" alt="img"></span>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="Enter your email address" value="{{ old('email') }}" required>
                                </div>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
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
                                <label for="password_confirmation">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pass-input"
                                        placeholder="Confirm your password" required>
                                </div>
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
