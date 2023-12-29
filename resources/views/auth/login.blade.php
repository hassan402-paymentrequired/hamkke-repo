@extends('layouts.guest', ['pageTitle' => 'Login'])

@section('content')
    <h4 class="mb-1 pt-2">Welcome to {{ config('app.name', 'Hamkke') }} 👋</h4>
    <p class="mb-4">Enter your email address and password to proceed</p>

    <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 form-group">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}"
                placeholder="Enter your email address"required>
            @form_field_error('email')
        </div>
        <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
                <label for="email" class="form-label">Password <span class="text-danger">*</span></label>
                <a href="{{ route('password.request') }}">
                    <small>Forgot Password?</small>
                </a>
            </div>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me" name="remember_me" />
                <label class="form-check-label" for="remember-me"> Remember Me </label>
            </div>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
        </div>
    </form>
@endsection
