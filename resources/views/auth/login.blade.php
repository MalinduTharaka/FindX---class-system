<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Class System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login page" />
    <meta name="author" content="Your Name" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('logo/edu-logo.jpg') }}">

    <!-- Styles -->
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- JS Config -->
    <script src="{{ asset('assets/js/config.min.js') }}"></script>
</head>

<body class="authentication-bg">

    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="card auth-card">
                        <div class="card-body px-3 py-5">
                            <div class="mx-auto mb-4 text-center auth-logo">
                                <a href="{{ url('/') }}" class="logo-dark">
                                    <img src="{{ asset('logo/edu-logo.jpg') }}" height="70" class="me-1" alt="logo sm">
                                </a>
                            </div>

                            <h2 class="fw-bold text-center fs-18">Sign In</h2>
                            <p class="text-muted text-center mt-1 mb-4">Enter your email and password to login.</p>

                            <div class="px-4">
                                <!-- Blade Validation Errors -->
                                <x-validation-errors class="mb-3 text-danger" />

                                @if (session('status'))
                                    <div class="mb-4 font-medium text-sm text-success text-center">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                    </div>

                                    <div class="mb-3">
                                        <a href="{{ route('password.request') }}" class="float-end text-muted text-unline-dashed ms-1">Reset password</a>
                                        <label for="password" class="form-label">Password</label>
                                        <x-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <x-checkbox id="remember_me" name="remember" class="form-check-input" />
                                            <label class="form-check-label" for="remember_me">Remember me</label>
                                        </div>
                                    </div>

                                    <div class="mb-1 text-center d-grid">
                                        <x-button class="btn btn-primary">
                                            {{ __('Log in') }}
                                        </x-button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->

                    <p class="mb-0 text-center">New here? <a href="{{ route('register') }}" class="text-reset fw-bold ms-1">Sign Up</a></p>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/vendor.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
