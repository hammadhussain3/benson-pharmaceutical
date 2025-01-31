@extends('admin.layouts.app')

@section('content')
<style>
    .edit-profile-img{
        cursor: pointer;
    }
    .overlay{
        background: rgba(0, 0, 0, 0.5); 
        opacity: 0; 
        transition: opacity 0.3s;
    }
    .edit-profile-img:hover .overlay {
        opacity: 1;
    }
</style>
    <div class="page-header">
        <div class="page-title">
            <h4>Profile</h4>
            <h6>User Profile</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="profile-set">
                <div class="profile-head">
                </div>
                <div class="profile-top">
                    <form class="profile-content" method="POST" action="{{ route('profile.image.update') }}" enctype="multipart/form-data">
                        @csrf
                        <label for="image" class="flex-shrink-0 profile-contentimg border-0 w-auto rounded-0 shadow-none position-relative edit-profile-img">
                            <img src="{{ asset('assets/img/profile/' . ($user->image ?? 'default.png')) }}" alt="Profile Picture" class="rounded-circle border border-5 border-light shadow" style="width: 120px; height: 120px;">
                            <div class="overlay position-absolute top-0 start-0 d-flex align-items-center justify-content-center text-white rounded-circle" style="width: 120px; height: 120px;">
                                Change Picture
                            </div>
                            <input type="file" name="image" id="image" hidden onchange="this.form.submit()">
                        </label>
                        <div class="flex-grow-1 ms-3 profile-contentname">
                            <h2>{{ $user->name }}</h2>
                            <h4>Update your personal details.</h4>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <form id="profile-form" method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                </div>
                <button class="btn btn-submit" type="submit">Update Profile</button>
            </form>
        </div>

        <div class="col-lg-6 col-sm-12">
            <form id="password-form" method="post" action="{{ route('password.chnage') }}">
                @csrf
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button class="btn btn-submit" type="submit">Update Password</button>
            </form>
        </div>
        {{-- @if (!auth()->user()->hasRole('Superadmin'))
            <div class="col-lg-12">
                <form id="delete-form" method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="form-group">
                        <label for="password">Confirm Password to Delete Account</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-danger" type="submit">Delete Account</button>
                </form>
            </div>
        @endif --}}
    </div>
    </div>
    </div>
    <style>
        .avatar {
            width: 120px;
            /* Adjust size as needed */
            height: 100px;
            /* Adjust size as needed */
            border-radius: 50%;
            /* Makes it circular */
            background-color: #f99940;
            /* Background color */
            color: #fff;
            /* Text color */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            /* Font size */
            font-weight: bold;
            /* Make the text bold */
        }
    </style>
@endsection
