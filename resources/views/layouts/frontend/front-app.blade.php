@php
    use App\Models\PostType;
@endphp
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('frontend-assets/bootstrap-5.3.2-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/styles.css') }}" type="text/css">
    <link href="//cdn-images.mailchimp.com/embedcode/classic-061523.css" rel="stylesheet" type="text/css">
    <style>
        #mc_embed_signup {
            background: #fff;
            padding: 0.1em;
            clear: left;
            font: 14px Helvetica, Arial, sans-serif;
            max-width: 600px !important;
            width: 100%;
            border-radius: 5px;
            margin-bottom: 2em;
        }
        footer > div {
            text-align: center;
            color: inherit;
            margin: auto;
            max-width: 650px;
        }
        .footer-note {
            font-size: 20px;
            line-height: 32px;
        }

        /* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
           We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
    </style>
    <title>{{ $pageTitle ? "{$pageTitle} :: " : '' }}Hamkke Chingu</title>
</head>

<body class="article-body">
@include('layouts.frontend.navigation', ['registeredPostTypes' => PostType::all()])

@yield('content')


<footer>
    <div class="d-flex justify-content-center text-white">
        <p class="footer-note">
            Hamkke is your very own space to learn, share and enjoy the <br>Korean Language and Culture with other
            enthusiasts like yourself. <br><br>
            Welcome! Let’s #StudyHamkke
        </p>
    </div>
    <div class="d-flex justify-content-center">
        <div id="mc_embed_shell">
            <div id="mc_embed_signup">
                <form
                    action="https://hamkkechingu.us11.list-manage.com/subscribe/post?u=a78a1262d9597ad13fb03fa9a&amp;id=ea5a2d75e1&amp;f_id=00baa8e0f0"
                    method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate"
                    target="_self" novalidate="">
                    <div id="mc_embed_signup_scroll"><h2>Don’t miss out on all the special stuff! Join the Hamkke Clan👇</h2>
                        <div class="mc-field-group"><label for="mce-EMAIL">Email Address <span class="asterisk">*</span></label><input
                                type="email" name="EMAIL" class="required email" id="mce-EMAIL" required=""
                                value=""><span id="mce-EMAIL-HELPERTEXT" class="helper_text"></span></div>
                        <div hidden=""><input type="hidden" name="tags" value="9358105"></div>
                        <div id="mce-responses" class="clear foot">
                            <div class="response" id="mce-error-response" style="display: none;"></div>
                            <div class="response" id="mce-success-response" style="display: none;"></div>
                        </div>
                        <div aria-hidden="true" style="position: absolute; left: -5000px;">
                            /* real people should not fill this in and expect good things - do not remove this or risk
                            form bot signups */
                            <input type="text" name="b_a78a1262d9597ad13fb03fa9a_ea5a2d75e1" tabindex="-1" value="">
                        </div>
                        <div class="optionalParent">
                            <div class="clear foot">
                                <input type="submit" name="subscribe" id="mc-embedded-subscribe" class="button"
                                       value="Subscribe">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

{{--    <div class="brand-div text-center">--}}
{{--        <a class="footer-brand" href="{{ url('/') }}" style="text-transform: uppercase;">--}}
{{--            {{ $coreSiteDetails->siteName() }}--}}
{{--        </a>--}}
{{--    </div>--}}

    <div class="d-flex justify-content-center">
        @include('components.front-social-links-section')
    </div>

    <div class="copyright-div text-center">Copyright
        <img src="{{ asset('frontend-assets/copyright_FILL0_wght400_GRAD0_opsz48 1.png') }}" alt="copyright icon"/>
        2023 {{ $coreSiteDetails->siteName() }}
    </div>
</footer>

<script src="{{ asset('cms-assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('frontend-assets/bootstrap-5.3.2-dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset("cms-assets/vendor/libs/quill/katex.js") }}"></script>
<script src="{{ asset("cms-assets/vendor/libs/quill/quill.js") }}"></script>
<script src="{{ asset('cms-assets/js/main.js') }}"></script>

@yield('more-scripts')
</body>

</html>
