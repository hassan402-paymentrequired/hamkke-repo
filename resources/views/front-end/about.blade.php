@extends('layouts.frontend.front-app', ['pageTitle' => 'Home'])

@section('content')
    <section class="about-div">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center">
                <div class="text-bg" id="aboutUsPageContent">
{{--                    <h4>About Us</h4>--}}
{{--                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the--}}
{{--                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type--}}
{{--                        and scrambled it to make a type specimen book.--}}
{{--                        It has survived not only five centuries, but also the leap into electronic typesetting, remaining--}}
{{--                        essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets--}}
{{--                        containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus--}}
{{--                        PageMaker including versions of Lorem Ipsum.--}}
{{--                        Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of--}}
{{--                        classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin--}}
{{--                        professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words,--}}
{{--                        consectetur, from a Lorem Ipsum passage.--}}
{{--                    </p>--}}
                    <button><a href="#contact">Contact Us</a></button>
                </div>
            </div>
        </div>
    </section>

    <section class="container contact-div" id="contact">
        <div class="row marginX">
            <div class="col-md-6">
                <div class="contact-form">
                    <form action="{{ route('contact_us') }}" id="contactForm" method="post" enctype="multipart/form-data">
                        <h4>Contact Us</h4>
                        <input type="text" placeholder="Name" name="name" required />
                        <input type="email" placeholder="Email Address" name="email" required/>
                        <input type="number" placeholder="Phone Number" name="phone" />
                        <textarea placeholder="Type your message" name="content"></textarea>
                        <button type="submit" class="btn btn-primary"> Send Message </button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="img-box">
                    <img src="{{ asset('frontend-assets/ConactUs-img.png') }}" />
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
