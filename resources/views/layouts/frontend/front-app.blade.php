@php
    use App\Models\PostType;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Core CSS -->
{{--    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/css/rtl/core.css') }}"/>--}}
    <link href="{{ asset('frontend-assets/bootstrap-5.3.2-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/fonts/fontawesome.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/sweetalert2/sweetalert2.min.css') }}"/>
    <link rel="stylesheet" href="{{ assetWithVersion('frontend-assets/css/styles.css') }}" type="text/css">
    <link href="//cdn-images.mailchimp.com/embedcode/classic-061523.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ assetWithVersion('cms-assets/css/select2.css') }}"/>

    <link href="{{ assetWithVersion('frontend-assets/css/custom-styles.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/quill/typography.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/quill/katex.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/quill/editor.css') }}"/>

    <script src="{{ asset('cms-assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ assetWithVersion('cms-assets/js/config.js') }}"></script>
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

<body class="{{ isset($bodyClass) ? $bodyClass : 'article-body' }}">
@if(auth('web')->check())
    @include('components.front.top-admin-row')
@endif

@if(!isAdminRoute())
    @include('components.front.navigation', ['registeredPostTypes' => PostType::all()])
@endif

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
                    action="https://wordpress.us20.list-manage.com/subscribe/post?u=4a3c302ee2560c38b3c427157&amp;id=7ffb6ce758&amp;f_id=001405eaf0"
                    method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
                    <div id="mc_embed_signup_scroll">
                        <h2>Don’t miss out on all the special stuff! Join the Hamkke Clan👇</h2>
                        <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
                        <div class="mc-field-group"><label for="mce-EMAIL">Email Address <span class="asterisk">*</span></label><input
                                type="email" name="EMAIL" class="required email" id="mce-EMAIL" required="" value=""><span
                                id="mce-EMAIL-HELPERTEXT" class="helper_text"></span></div>
                        <div id="mce-responses" class="clear foot">
                            <div class="response" id="mce-error-response" style="display: none;"></div>
                            <div class="response" id="mce-success-response" style="display: none;"></div>
                        </div>
                        <div aria-hidden="true" style="position: absolute; left: -5000px;">
                            /* real people should not fill this in and expect good things - do not remove this or risk form bot signups */
                            <input type="text" name="b_4a3c302ee2560c38b3c427157_7ffb6ce758" tabindex="-1" value="">
                        </div>
                        <div class="optionalParent">
                            <div class="clear foot">
                                <input type="submit" name="subscribe" id="mc-embedded-subscribe" class="button" value="Subscribe">
                                <p style="margin: 0 auto;">
                                    <a href="http://eepurl.com/iraQMc" title="Mailchimp - email marketing made easy and fun">
                                        <span style="display: inline-block; background-color: transparent; border-radius: 4px;">
                                            <img class="refferal_badge" alt="Intuit Mailchimp"
                                                src="https://digitalasset.intuit.com/render/content/dam/intuit/mc-fe/en_us/images/intuit-mc-rewards-text-dark.svg"
                                                style="width: 220px; height: 40px; display: flex; padding: 2px 0px; justify-content: center; align-items: center;">
                                        </span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- / Layout page -->
    <form action="javascript:void(0);" method="POST" id="site-wide-action-form" style="display: none;">
        @csrf
    </form>

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
<script src="{{ asset('frontend-assets/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset("cms-assets/vendor/libs/quill/katex.js") }}"></script>
<script src="{{ asset("cms-assets/vendor/libs/quill/quill.js") }}"></script>
<script src="{{ asset("cms-assets/vendor/libs/quill/modules/imageResizer.min.js") }}"></script>
<script src="https://unpkg.com/quill-image-compress@1.2.11/dist/quill.imageCompressor.min.js"></script>
<script>
    Quill.register("modules/imageCompressor", imageCompressor)
    Quill.register("modules/ImageResize", ImageResize.default)
</script>
<script src="{{ asset('cms-assets/vendor/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ assetWithVersion('js/hamkke-custom-helpers.js') }}"></script>\
<script>
    (function ($){
        $(document).ready(function () {
            const select2 = $('.select2');
            if (select2.length) {
                select2.each(function () {
                    let $this = $(this);
                    let maximumSelectionLength = parseInt($this.data('maximumSelectionLength'));
                    console.log({ placeholder: $this.data('select-placeholder') })
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: $this.data('select-placeholder') ? $this.data('select-placeholder'): 'Select Tag',
                        dropdownParent: $this.parent(),
                        maximumSelectionLength
                    });
                });
            }
        });
    })(jQuery);
</script>
@component('components.frontend-alerts') @endcomponent
@yield('more-scripts')
</body>

</html>
