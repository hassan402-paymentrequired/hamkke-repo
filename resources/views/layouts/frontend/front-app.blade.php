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
    <title>{{ $pageTitle ? "{$pageTitle} :: " : '' }}Hamkke Chingu</title>
</head>

<body class="article-body">
    @include('layouts.frontend.navigation', ['registeredPostTypes' => PostType::all()])

    @yield('content')


    <footer>
        <div class="brand-div text-center">
            <a class="footer-brand" href="{{ url('/') }}" style="text-transform: uppercase;">
                {{ $coreSiteDetails->siteName() }}
            </a>
        </div>

        <div class="d-flex justify-content-center">
            @include('components.front-social-links-section')
        </div>

        <div class="copyright-div text-center">Copyright
            <img src="{{ asset('frontend-assets/copyright_FILL0_wght400_GRAD0_opsz48 1.png') }}" alt="copyright icon" />
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
