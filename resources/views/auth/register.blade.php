<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register | Class System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Register page" />
    <meta name="author" content="Your Name" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('logo/edu-logo.jpg') }}">
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
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

                            <h2 class="fw-bold text-center fs-18">Register</h2>
                            <p class="text-muted text-center mt-1 mb-4">Create a new account to access the dashboard.</p>

                            <div class="px-4">
                                <x-validation-errors class="mb-3 text-danger" />

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <x-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <x-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <x-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                                    </div>

                                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                        <div class="mb-3 form-check">
                                            <x-checkbox name="terms" id="terms" class="form-check-input" required />
                                            <label for="terms" class="form-check-label ms-2">
                                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-muted text-decoration-underline">'.__('Terms of Service').'</a>',
                                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-muted text-decoration-underline">'.__('Privacy Policy').'</a>',
                                                ]) !!}
                                            </label>
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-between align-items-center mt-4">

                                        <x-button class="btn btn-primary">
                                            {{ __('Register') }}
                                        </x-button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->

                    <p class="mb-0 text-center">Back to <a href="{{ url('/') }}" class="text-reset fw-bold ms-1">Login</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/vendor.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
