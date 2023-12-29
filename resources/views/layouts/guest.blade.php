<!DOCTYPE html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
	data-assets-path="{{ asset('frontend-assets') }}" data-template="vertical-menu-template-no-customizer">

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
	<link rel="stylesheet" href="{{ asset('cms-assets/css/demo.css') }}" />

	<!-- Vendors CSS -->
	<link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/node-waves/node-waves.css') }}" />
	<link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
	<link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/typeahead-js/typeahead.css') }}" />
	<!-- Vendor -->
	<link rel="stylesheet" href="{{ asset('cms-assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />

	<!-- Page CSS -->
	<!-- Page -->
	<link rel="stylesheet" href="{{ asset('cms-assets/vendor/css/pages/page-auth.css') }}" />
	<link rel="stylesheet" href="{{ asset('cms-assets/css/main-auth.css') }}" />

	<!-- Helpers -->
	<script src="{{ asset('cms-assets/vendor/js/helpers.js') }}"></script>
	<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
	<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
	<script src="{{ asset('cms-assets/js/config.js') }}"></script>
</head>

<body>
	<!-- Content -->

	<div class="container-xxl">
		<div class="authentication-wrapper authentication-basic container-p-y">
			<div class="authentication-inner py-4">
				<!-- Login -->
				<div class="card">
					<div class="card-body">
						<!-- Logo -->
						<div class="app-brand justify-content-center mb-4 mt-2">
							<a href="index.html" class="app-brand-link gap-2">
								<span class="app-brand-logo demo">
									@include('components.application-logo')
								</span>
								<span class="app-brand-text demo text-body fw-bold ms-1">HAMKKE</span>
							</a>
						</div>
						@yield('content')
					</div>
				</div>
				<!-- /Register -->
			</div>
		</div>
	</div>

	<!-- / Content -->

	<!-- Core JS -->
	<!-- build:js assets/vendor/js/core.js -->

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
	<script src="{{ asset('cms-assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
	<script src="{{ asset('cms-assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
	<script src="{{ asset('cms-assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>

	<!-- Main JS -->
	<script src="{{ asset('cms-assets/js/main.js') }}"></script>

	<!-- Page JS -->
	<script src="{{ asset('cms-assets/js/pages-auth.js') }}"></script>
</body>

</html>