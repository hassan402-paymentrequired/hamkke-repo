<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
      data-theme="theme-default" data-assets-path="{{ asset('cms-assets') }}"
      data-template="vertical-menu-template-no-customizer">
<head>

    @include(backpack_view('inc.head'))
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.jpeg') }}"/>

    @yield('more-styles')

</head>

<body class="font-sans antialiased">

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include(backpack_view('inc.sidebar'))
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Main-Header -->
                @include(backpack_view('inc.main_header'))
                <!-- / Main-Header -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Content -->
                        {{--                    @include(backpack_view('inc.alert'))--}}

                        @yield('before_breadcrumbs_widgets')
                        @includeWhen(isset($breadcrumbs), backpack_view('inc.breadcrumbs'))
                        @yield('after_breadcrumbs_widgets')

                        @yield('before_content_widgets')
                        @yield('content')
                        @yield('after_content_widgets')

                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    @include(backpack_view('inc.footer'))

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
</body>
</html>
