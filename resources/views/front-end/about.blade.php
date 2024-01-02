@extends('layouts.frontend.front-app', ['pageTitle' => 'Home'])

@section('content')
    <section class="about-div">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center">
                <div class="text-bg" id="aboutUsPageContent">
                    <h4>About Us</h4>
                    <p>Hi there. &#x1F44B;&#127998;<br>
                        So you’re here, and you’re probably wondering what this place is. Let me be the first to welcome
                        you to <strong>"Hamkke"</strong>; the number one online community for all Nigerians who are interested in the
                        language, media, and culture of Korea.</p>
                    <p>If you are like me, you probably watched your first Korean drama a few years ago, and it blew
                        your mind. Everything from the comedy, to the attractive actors, the endless number of moments,
                        and the predictable yet unexpected plot twists, was extremely intriguing. And so you started to
                        take an interest in the soundtracks, the cultural inferences, and the pop culture references
                        among other things. Then you found yourself trying to understand Hallyu beyond the surface.
                        <br><br>
                        Or maybe you are just someone who is interested in the media and culture of Korea for the simple
                        reason that it has become a major global force in entertainment. Either way, you have come to
                        the right place. If you are Nigerian, this place is perfect for you because it caters
                        specifically to your needs as a Nigerian Hallyu fan. For a lot of Nigerians or even Africans who
                        are interested in Hallyu, it is almost as though you are giving a lot of attention to what
                        should be a mere passing interest. At least, that’s how other people see it.
                        <br><br>
                        It’s not like you understand the language or anything. <em>Pffft</em>
                        <br><br>
                        However, I understand you and will not in any way belittle your love for K-Pop or K- Drama, or
                        anything Hallyu that you love. Instead, I will validate that interest and help you feed it in
                        every way possible. This way, we can have some fun and friendships while we learn about and
                        experience Hallyu together, just like the name implies.
                        <br><br>
                        <span class="font-weight-bold">Welcome to “HAMKKE”!</span>
                    </p>
                    <p><button><a href="#contact">Contact Us</a></button></p>
                </div>
            </div>
        </div>
    </section>

    <section class="container contact-div" id="contact">
        <div class="row marginX">
            <div class="col-md-6">
                <div class="contact-form">
                    <form action="{{ route('contact_us') }}" id="contactForm" method="post"
                          enctype="multipart/form-data">
                        <h4>Contact Us</h4>
                        <input type="text" placeholder="Name" name="name" required/>
                        <input type="email" placeholder="Email Address" name="email" required/>
                        <input type="number" placeholder="Phone Number" name="phone"/>
                        <textarea placeholder="Type your message" name="content"></textarea>
                        <button type="submit" class="btn btn-primary"> Send Message</button>
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
