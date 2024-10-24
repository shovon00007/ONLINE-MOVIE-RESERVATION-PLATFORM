@extends('layouts.app')

@section('content')
<!-- Custom CSS for Register Page -->
<style>
    body {
        background-image: url('{{ asset('images/register-bg.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        color: white;
        font-family: 'Poppins', sans-serif;
    }

    .register-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .card {
        background-color: rgba(0, 0, 0, 0.8);
        border-radius: 15px;
        color: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }

    .card-header {
        font-size: 28px;
        font-weight: 700;
        text-align: center;
        background-color: rgba(0, 0, 0, 0.6);
        border-bottom: none;
        padding: 20px;
    }

    .card-body {
        padding: 40px;
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        padding: 10px;
        font-size: 16px;
    }

    .form-control:focus {
        background-color: rgba(255, 255, 255, 0.4);
        color: white;
        border-color: #ffc107;
        box-shadow: 0 0 5px #ffc107;
    }

    .form-check-label {
        color: white;
    }

    .btn-primary {
        background-color: #ffc107;
        border-color: #ffc107;
        padding: 10px 30px;
        font-size: 18px;
        border-radius: 30px;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #ff9f00;
        border-color: #ff9f00;
    }

    .invalid-feedback {
        color: #ff6f61;
    }

    /* Extra transitions for input fields */
    .form-control {
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }
</style>

<!-- JavaScript for Smooth Transitions -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const formInputs = document.querySelectorAll('.form-control');
        formInputs.forEach(input => {
            input.addEventListener('focus', function () {
                this.style.backgroundColor = 'rgba(255, 255, 255, 0.4)';
                this.style.boxShadow = '0 0 8px #ffc107';
            });
            input.addEventListener('blur', function () {
                this.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
                this.style.boxShadow = 'none';
            });
        });
    });
</script>

<!-- Register Page Content -->
<div class="register-container">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('Register') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name Input -->
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <!-- Register Button -->
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
