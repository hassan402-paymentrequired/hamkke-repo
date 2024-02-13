@extends('layouts.frontend.front-app', ['pageTitle' => 'Customer Sign-up', 'bodyClass' => 'login-body'])

@section('content')
    <section class="section mb-5">

        <div class="login-div">
            <div class="d-flex justify-content-center">

                <form action="{{ route('customer.auth.register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="title text-center">Register</div>

                    <div class="login">
                        <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                        <input required type="text" id="name" name="name" placeholder="name" value="{{ old('name') }}" />
                        @form_field_error('name')

                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" placeholder="Email" required value="{{ old('email') }}" />
                        @form_field_error('email')

                        <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                        <input type="password" id="password" name="password" placeholder="Password" required/>
                        @form_field_error('password')

                        <label for="password_confirmation" class="form-label">Confirm Password<span class="text-danger">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Password"/>
                    </div>

                    <div class="d-flex check-div">
                        <input type="checkbox" name="remember"/>
                        <span>Remember Me</span>
                    </div>

                    <button class="login-btn" type="submit">Register</button>

                    <div class="or text-center">OR</div>

                    <div class="signup-link">Already have an account? <a href="{{ route('customer.auth.login') }}">Login</a></div>

                </form>

            </div>

        </div>
    </section>
@endsection
