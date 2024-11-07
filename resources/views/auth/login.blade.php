<x-guest-layout>
<head>
    <style>
        /* Container for full-screen login page */
        .login-container {
            display: flex;
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
        }

        /* Styling for the form section on the left with reduced width */
        .form-section {
            background: linear-gradient(196.32deg, #97EEC8 0.87%, #0085AA 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 40vw; /* Reduced width to move it to the left */
            flex-direction: column;
        }

        /* Logo styling outside the form box */
        .logo-container {
            margin-bottom: 1rem;
        }

        .Logo-img {
            width: 300px;
        }

        /* Rounded form container within the form section */
        .form-box {
            background-color: #FFFFFF99; /* Light background for the box */
            padding: 2rem;
            border-radius: 20px; /* Rounded corners */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Soft shadow */
            width: 100%;
            max-width: 400px; /* Limit box width */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Form input styling */
        .form-label {
            color: #0072ff; /* Text color to match design */
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
            background-color: #ffffff;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid #cccccc;
            font-size: 1rem;
            color: #333333;
            margin-bottom: 1rem;
        }

        /* Checkbox and button styling */
        .form-check-label {
            color: #0072ff;
        }

        .btn {
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: bold;
            color: #0072ff;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .btn:hover {
            background-color: #e0f7fa;
        }

        /* Forgot password link styling */
        .text-center a {
            color: #0072ff;
            text-decoration: none;
        }

        /* Image section styling on the right with increased width */
        .image-section {
            width: 60vw; /* Increased width to fill remaining space */
            overflow: hidden;
        }

        .image-section img {
            object-fit: cover;
            height: 100vh;
            width: 100%;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .form-section, .image-section {
                width: 100vw; /* Full width for each section on smaller screens */
            }

            .image-section img {
                height: 50vh; /* Adjust image height on small screens */
            }
        }
    </style>
</head>
    <div class="login-container">
        <!-- Logo Outside Form Box in Form Section on the Left -->
        <div class="form-section">
            <div class="logo-container">
                <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="img-fluid Logo-img">
            </div>

            <!-- Rounded Form Box -->
            <div class="form-box">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="w-100">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Username') }}</label>
                        <input id="email" type="email" name="email" class="form-control" :value="old('email')" required autofocus autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="text-danger mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="text-danger mt-2" />
                    </div>

                    <!-- Login Button and Forgot Password Link -->
                    <div class="d-grid">
                        <button type="submit" class="btn">{{ __('Login') }}</button>
                    </div>
                    <div class="text-center mt-3">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none">{{ __('Forgot your password?') }}</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Full-Height Image Section on the Right -->
        <div class="image-section">
            <img src="{{ asset('images/doctorlogin.png') }}" alt="Doctor Image" class="img-fluid">
        </div>
    </div>
</x-guest-layout>
