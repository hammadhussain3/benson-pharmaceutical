<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Register - Streamline</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.jpg') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="login-logo">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="img">
                        </div>
                        <div class="login-userheading">
                            <h3>Create an Account</h3>
                            <h4>Continue where you left off</h4>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <!-- Full Name -->
                            <div class="form-login">
                                <label for="name">Full Name</label>
                                <div class="form-addons">
                                    <input type="text" id="name" name="name"
                                        placeholder="Enter your full name" value="{{ old('name') }}" required
                                        autofocus>
                                    <img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img">
                                </div>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="form-login">
                                <label for="email">Email</label>
                                <div class="form-addons">
                                    <input type="email" id="email" name="email"
                                        placeholder="Enter your email address" value="{{ old('email') }}" required>
                                    <img src="{{ asset('assets/img/icons/mail.svg') }}" alt="img">
                                </div>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-login">
                                <label for="password">Password</label>
                                <div class="pass-group">
                                    <input type="password" id="password" name="password"
                                        placeholder="Enter your password" required>
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-login">
                                <label for="password_confirmation">Confirm Password</label>
                                <div class="pass-group">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        placeholder="Confirm your password" required>
                                </div>
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="form-login">
                                <button type="submit" class="btn btn-login">Sign Up</button>
                            </div>
                        </form>

                        <div class="text-center signinform">
                            <h4>Already a user? <a href="{{ route('login') }}" class="hover-a">Sign In</a></h4>
                        </div>

                    </div>
                </div>
                <div class="login-img">
                    <img src="{{ asset('assets/img/login.jpg') }}" alt="img">
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
