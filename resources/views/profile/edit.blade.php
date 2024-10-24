@extends('admin.layouts.app')

@section('content')
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
                    <div class="profile-content">
                        <div class="profile-contentimg">
                            <!-- Replace the image tag with a div for the letter avatar -->
                            <div class="avatar">
                                {{ strtoupper(substr($user->name, 0, 1)) }} <!-- Get the first letter of the user's name -->
                            </div>

                        </div>
                        <div class="profile-contentname">
                            <h2>{{ $user->name }}</h2>
                            <h4>Update your personal details.</h4>
                        </div>
                    </div>

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
                    <input type="text" name="name" placeholder="{{ $user->name }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="{{ $user->email }}" class="form-control" required>
                </div>
                <button class="btn btn-submit" type="submit">Update Profile</button>
            </form>
        </div>

        <div class="col-lg-6 col-sm-12">
            <form id="password-form" method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')
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
