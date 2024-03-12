@props(['title'])
<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
      data-theme="theme-default" data-assets-path="{{ asset('cms-assets') }}"
      data-template="vertical-menu-template-no-customizer">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>{{ $title ? "{$title} - " : '' }}{{ config('app.name', 'Hamkke') }}</title>

    <meta name="description" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.jpeg') }}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet"/>

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/fonts/fontawesome.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/fonts/tabler-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/fonts/flag-icons.css') }}"/>

    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/css/rtl/core.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/css/rtl/theme-default.css') }}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/node-waves/node-waves.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/typeahead-js/typeahead.css') }}"/>

    <link rel="stylesheet" href="{{ assetWithVersion('cms-assets/css/main.css') }}"/>
    <link rel="stylesheet" href="{{ assetWithVersion('css/errors.css') }}"/>

</head>

<body class="font-sans antialiased">

<!-- Layout wrapper -->
<div class="container-xxl container-p-y">
    <div class="misc-wrapper">
        <h2 class="mb-1 mx-2">{{ $title }}</h2>
        <p class="mb-4 mx-2">{{ $message }}</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary mb-4">Back to home</a>
        <div class="mt-4">
            <img
                src="{{ $image ?? asset('cms-assets/illustrations/page-misc-under-maintenance.png') }}"
                alt="page-misc-not-authorized"
                width="170"
                class="img-fluid" />
        </div>
    </div>
</div>
<div class="container-fluid misc-bg-wrapper">
    <img
        src="{{ assetWithVersion('cms-assets/illustrations/bg-shape-image-light.png') }}"
        alt="page-misc-not-authorized" />
</div>
<!-- / Layout wrapper -->

<!-- Helpers -->
<script src="{{ asset('cms-assets/vendor/js/helpers.js') }}"></script>
<script src="{{ asset('cms-assets/js/config.js') }}"></script>

<script src="{{ asset('cms-assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/js/menu.js') }}"></script>

<!-- Main JS -->
<script src="{{ assetWithVersion('js/hamkke-custom-helpers.js') }}"></script>
<script src="{{ assetWithVersion('cms-assets/js/main.js') }}"></script>

</body>

</html>

