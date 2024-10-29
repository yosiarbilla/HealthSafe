<x-guest-layout>
<head>
    <style>
        /* Container for login page */
        .login-container {
            display: flex;
            max-width: 1000px;
            height: 100vh;
        }

        /* Styling for the form section */
        .form-section {
            background: linear-gradient(to bottom right, #00c6ff, #0072ff);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 3rem;
        }

        /* Logo styling */
        .logo-container {
            margin-bottom: 1.5rem;
        }

        .Logo-img {
            width: 80px;
        }

        /* Form input styling */
        .form-label {
            color: white;
        }

        .form-control {
            border-radius: 0.25rem;
        }

        /* Checkbox and button styling */
        .form-check-label {
            color: white;
        }

        .btn {
            font-weight: bold;
        }

        /* Forgot password link */
        .text-center a {
            color: white;
            text-decoration: none;
        }

        /* Image section styling */
        .col-md-6.p-0 img {
            object-fit: cover;
            height: 100%;
            width: 100%;
            border-top-right-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }
    </style>
</head>
    <div class="row login-container shadow-lg rounded">
        <!-- Login Form Section -->
        <div class="col-md-6 p-5 d-flex flex-column align-items-center text-white" style="background: linear-gradient(to bottom right, #00c6ff, #0072ff);">
            <div class="mb-4">
                <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="img-fluid" style="width: 80px;">
            </div>
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="w-100">
                @csrf
                
                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label text-white">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" class="form-control" :value="old('email')" required autofocus autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="text-danger mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label text-white">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
                    <x-input-error :messages="$errors->get('password')" class="text-danger mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label class="form-check-label text-white" for="remember_me">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <!-- Login Button and Forgot Password Link -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-light text-primary fw-bold">{{ __('Log in') }}</button>
                </div>
                <div class="text-center mt-3">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-white text-decoration-none">{{ __('Forgot your password?') }}</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Image Section -->
        <div class="col-md-6 p-0">
            <img src="{{ asset('images/doctorlogin.png') }}" alt="Doctor Image" class="img-fluid h-100 w-100 rounded-end" style="object-fit: cover;">
        </div>
    </div>
</x-guest-layout>
