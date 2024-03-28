<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
      data-theme="theme-default" data-assets-path="{{ asset('cms-assets') }}"
      data-template="vertical-menu-template-no-customizer">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>{{ $pageTitle ? "{$pageTitle} - " : '' }}{{ config('app.name', 'Hamkke') }}</title>

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

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/css/rtl/core.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/css/select2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/css/rtl/theme-default.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/sweetalert2/sweetalert2.min.css') }}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/node-waves/node-waves.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/typeahead-js/typeahead.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/toastr/toastr.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/select2/select2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/tagify/tagify.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/apex-charts/apex-charts.css') }}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/quill/typography.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/quill/katex.css') }}"/>
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/quill/editor.css') }}"/>
    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ assetWithVersion('cms-assets/css/main.css') }}"/>

    @vite('resources/js/app.js')
    @yield('more-styles')

</head>

<body class="font-sans antialiased">

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        @include('layouts.navigation')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('layouts.header')

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">

                <div class="container-xxl flex-grow-1 container-p-y">
                    <!-- Content -->
                    @include('components.alerts')

                    @yield('main-content')
                </div>
                <!-- / Content -->

                <!-- Footer -->
                @include('layouts.footer')
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
        <form action="javascript:void(0);" method="POST" id="site-wide-action-form" style="display: none;">
            @csrf
        </form>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
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
<script src="{{ asset('cms-assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/toastr/toastr.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/tagify/tagify.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/js/menu.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
<script src="{{ asset('cms-assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('cms-assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<!-- Vendors JS -->
<script src="{{ asset("cms-assets/vendor/libs/quill/katex.js") }}"></script>
<script src="{{ asset("cms-assets/vendor/libs/quill/quill.js") }}"></script>


<!-- Main JS -->
<script src="{{ assetWithVersion('js/hamkke-custom-helpers.js') }}"></script>
<script src="{{ assetWithVersion('cms-assets/js/main.js') }}"></script>

@yield('more-scripts')
</body>

</html>
