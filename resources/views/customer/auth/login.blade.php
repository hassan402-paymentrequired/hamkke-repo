@extends('layouts.frontend.front-app', ['pageTitle' => 'Customer Login', 'bodyClass' => 'login-body'])

@section('content')
    <section class="section mb-5">

        <div class="login-div">
            <div class="d-flex justify-content-center">

                <form action="{{ route('customer.auth.login') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="title text-center">Login to your account</div>

                    <div class="login">
                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" placeholder="Email"/>
                        @form_field_error('email')

                        <div class="d-flex justify-content-between mt-2">
                            <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
{{--                            <a href="auth-forgot-password-basic.html" class="text-decoration-none text-hamkke-purple">--}}
{{--                                <small>Forgot Password?</small>--}}
{{--                            </a>--}}
                        </div>
                        <input type="password" id="password" name="password" placeholder="Password"/>
                        @form_field_error('password')

                    </div>

                    <div class="d-flex check-div">
                        <input type="checkbox"/>
                        <span>Remember Me</span>
                    </div>

                    <button class="login-btn" type="submit">Login</button>
                    <div class="or text-center">OR</div>

                    <div class="signup-link">Dont have an account? <a href="{{ route('customer.auth.register') }}">Register</a></div>

                </form>

            </div>

        </div>
    </section>
@endsection
