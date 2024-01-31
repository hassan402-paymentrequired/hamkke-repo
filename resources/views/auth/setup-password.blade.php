@extends('layouts.guest', ['pageTitle' => 'Setup Password'])

@section('content')
    <h4 class="mb-1 pt-2">Setup Password 🔒</h4>
    <form id="formAuthentication" action="{{ route('password.store') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" autofocus
                   value="{{ old('email', $request->email) }}" />
            @form_field_error('email')
        </div>
        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password">New Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password"/>
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                @form_field_error('password')
            </div>
        </div>
        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="confirm-password">Confirm Password</label>
            <div class="input-group input-group-merge">
                <input
                    type="password"
                    id="confirm-password"
                    class="form-control"
                    name="password_confirmation"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password"/>
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
        </div>
        <button class="btn btn-primary d-grid w-100 mb-3">Continue</button>
        <div class="text-center">
            <a href="{{ route('login') }}">
                <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                Back to login
            </a>
        </div>
    </form>
@endsection
