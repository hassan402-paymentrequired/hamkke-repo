<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="{{ asset('cms-assets') }}"
    data-template="vertical-menu-template-no-customizer">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $pageTitle ? "{$pageTitle} - " : '' }}{{ config('app.name', 'Hamkke') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.jpeg') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('cms-assets/css/main.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('cms-assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('cms-assets/js/config.js') }}"></script>
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
                    <!-- Content -->

                    @yield('main-content')
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('layouts.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->
    <script src="{{ asset('cms-assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('cms-assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('cms-assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('cms-assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('cms-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('cms-assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('cms-assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('cms-assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('cms-assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('cms-assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('cms-assets/js/main.js') }}"></script>

    @yield('more-scripts')
</body>

</html>