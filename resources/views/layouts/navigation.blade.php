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
        <x-admin-nav-link routeName="dashboard" linkText="Dashboard" icon="ti-smart-home" />
        <li class="menu-item {{ isCurrentRoute(['admin.user.list', 'admin.user.create']) ? 'open': ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <em class="menu-icon tf-icons ti ti-users"></em>
                <div>Users</div>
            </a>
            <ul class="menu-sub">
                <x-admin-nav-link routeName="admin.user.list" linkText="All User" />

                <x-admin-nav-link routeName="admin.user.create" linkText="Add New User" />
            </ul>
        </li>

        <x-admin-nav-link routeName="admin.permissions.manage" linkText="Roles & Permissions" icon="ti-lock"/>

        <x-admin-nav-link routeName="admin.settings.general" linkText="Site Settings" icon="ti-settings"/>

        <!-- Apps & Pages -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Posts & Pages">Apps &amp; Pages</span>
        </li>
        <li class="menu-item {{ isCurrentRoute(['admin.post.list', 'admin.post.create', 'admin.category.list', 'admin.tag.list']) ? 'open': ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <em class="menu-icon tf-icons ti ti-file"></em>
                <div>Posts</div>
            </a>
            <ul class="menu-sub">
                <x-admin-nav-link routeName="admin.post.list" linkText="All Posts"/>

                <x-admin-nav-link routeName="admin.post.create" linkText="Add New Post"/>

                <x-admin-nav-link routeName="admin.category.list" linkText="Categories"/>

                <x-admin-nav-link routeName="admin.tag.list" linkText="Tags"/>
            </ul>
        </li>
        @php
        $forumRouteNames = ['admin.forum-post.list', 'admin.forum-discussion.list'];
        @endphp
        <li class="menu-item {{ isCurrentRoute($forumRouteNames) ? 'open': ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <em class="menu-icon tf-icons ti ti-file"></em>
                <div>Forum</div>
            </a>
            <ul class="menu-sub">
                <x-admin-nav-link routeName="admin.forum-post.list" linkText="All Thread"/>

                <x-admin-nav-link routeName="admin.forum-discussion.list" linkText="Forum Discussions"/>
            </ul>
        </li>
        <!-- Products & Payments -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Payment Management">Products & Payments</span>
        </li>

        <x-admin-nav-link routeName="admin.product-categories.list" linkText="Product Categories" icon="ti-list"/>

        <x-admin-nav-link routeName="admin.products.list" linkText="Products" icon="ti-shopping-bag"/>
    </ul>
</aside>
