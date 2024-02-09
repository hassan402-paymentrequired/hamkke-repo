<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('images/logo.jpeg') }}" alt="{{ $coreSiteDetails->siteName() }} Logo" height="22">
            </span>
            <span class="app-brand-text demo menu-text fw-bold">{{ $coreSiteDetails->siteName() }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <em class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></em>
            <em class="ti ti-x d-block d-xl-none ti-sm align-middle"></em>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @include(backpack_view('inc.sidebar_content'))
    </ul>
</aside>
