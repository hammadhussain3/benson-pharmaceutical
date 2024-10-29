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
    <title>Login - Streamline</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.jpg') }}">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="login-logo">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                        </div>
                        <div class="login-userheading">
                            <h3>Sign In</h3>
                            <h4>Please login to your account</h4>
                        </div>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="form-login">
                                <label for="email">{{ __('Email') }}</label>
                                <div class="form-addons">
                                    <input id="email" type="email" name="email" :value="old('email')" required
                                        autofocus placeholder="Enter your email address" />
                                    <img src="{{ asset('assets/img/icons/mail.svg') }}" alt="email-icon">
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="form-login">
                                <label for="password">{{ __('Password') }}</label>
                                <div class="pass-group">
                                    <input id="password" class="pass-input" type="password" name="password" required
                                        placeholder="Enter your password" />
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            {{-- <!-- Remember Me -->
                            <div class="form-login">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox" name="remember"
                                        class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500">
                                    <span class="text-sm text-gray-600 ms-2">{{ __('Remember me') }}</span>
                                </label>
                            </div> --}}

                            <!-- Forgot Password & Sign In Button -->
                            <div class="form-login">
                                @if (Route::has('password.request'))
                                    <div class="alreadyuser">
                                        <h4>
                                            <a href="{{ route('password.request') }}"
                                                class="hover-a">{{ __('Forgot Password?') }}</a>
                                        </h4>
                                    </div>
                                @endif
                            </div>

                            <div class="form-login">
                                <button type="submit" class="btn btn-login">{{ __('Sign In') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="login-img">
                    <img src="{{ asset('assets/img/login.jpg') }}" alt="login-img">
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