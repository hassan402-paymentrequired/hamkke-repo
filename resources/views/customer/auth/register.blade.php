@extends('layouts.frontend.front-app', ['pageTitle' => 'Customer Signup'])

@section('content')

    <section class="container contact-div" id="register">
        <div class="row marginX">
            <div class="col-md-6">
                <div class="contact-form">
                    <form action="{{ route('contact_us') }}" id="contactForm" method="post"
                          enctype="multipart/form-data">
                        <h4>Contact Us</h4>
                        <input type="text" placeholder="Username *" name="username" required/>
                        <input type="email" placeholder="Email Address *" name="email" required/>
                        <input type="number" placeholder="Phone Number" name="phone"/>
                        <textarea placeholder="Type your message" name="content"></textarea>
                        <button type="submit" class="btn btn-primary">Sign up</button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="img-box">
                    <img src="{{ asset('frontend-assets/ConactUs-img.png') }}"/>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('more_scripts')
    <script>
        $('body').addClass('about-body');
    </script>
@stop
