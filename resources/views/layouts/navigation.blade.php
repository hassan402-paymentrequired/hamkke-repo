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
        <li class="menu-item {{ isCurrentRoute('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <em class="menu-icon tf-icons ti ti-smart-home"></em>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ isCurrentRoute('user.list') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <em class="menu-icon tf-icons ti ti-users"></em>
                <div data-i18n="Users">Users</div>
            </a>
        </li>
        <li class="menu-item {{ isCurrentRoute('settings.roles_and_permissions') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <em class="menu-icon tf-icons ti ti-lock"></em>
                <div data-i18n="Roles & Permissions">Roles & Permissions</div>
            </a>
        </li>
        <li class="menu-item {{ isCurrentRoute('settings.general') ? 'active' : '' }}">
            <a href="{{ route('settings.general') }}" class="menu-link">
                <em class="menu-icon tf-icons ti ti-settings"></em>
                <div data-i18n="Site Settings">Site Settings</div>
            </a>
        </li>

        <!-- Apps & Pages -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Posts & Pages">Apps &amp; Pages</span>
        </li>
        <li class="menu-item {{ isCurrentRoute('post.list') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <em class="menu-icon tf-icons ti ti-file"></em>
                <div data-i18n="Posts">Posts</div>
            </a>
        </li>
    </ul>
</aside>
