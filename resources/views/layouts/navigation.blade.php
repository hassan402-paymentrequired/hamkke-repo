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
        <li class="menu-item {{ isCurrentRoute(['admin.user.list', 'admin.user.create']) ? 'open': ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <em class="menu-icon tf-icons ti ti-users"></em>
                <div>Users</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ isCurrentRoute('admin.user.list') ? 'active' : '' }}">
                    <a href="{{ route('admin.user.list') }}" class="menu-link">
                        <div>All Users</div>
                    </a>
                </li>
                <li class="menu-item {{ isCurrentRoute('admin.user.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.user.create') }}" class="menu-link">
                        <div>Add New User</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ isCurrentRoute('admin.permissions.manage') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <em class="menu-icon tf-icons ti ti-lock"></em>
                <div data-i18n="Roles & Permissions">Roles & Permissions</div>
            </a>
        </li>
        <li class="menu-item {{ isCurrentroute('admin.settings.general') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.general') }}" class="menu-link">
                <em class="menu-icon tf-icons ti ti-settings"></em>
                <div data-i18n="Site Settings">Site Settings</div>
            </a>
        </li>

        <!-- Apps & Pages -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Posts & Pages">Apps &amp; Pages</span>
        </li>
        <li class="menu-item {{ isCurrentRoute(['admin.post.list', 'admin.post.create']) ? 'open': ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <em class="menu-icon tf-icons ti ti-file"></em>
                <div>Posts</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ isCurrentRoute('admin.post.list') ? 'active' : '' }}">
                    <a href="{{ route('admin.post.list') }}" class="menu-link">
                        <div>All Posts</div>
                    </a>
                </li>
                <li class="menu-item {{ isCurrentRoute('admin.post.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.post.create') }}" class="menu-link">
                        <div>Add New Post</div>
                    </a>
                </li>

                <li class="menu-item {{ isCurrentRoute('admin.category.list') ? 'active' : '' }}">
                    <a href="{{ route('admin.category.list') }}" class="menu-link">
                        <div>Categories</div>
                    </a>
                </li>

                <li class="menu-item {{ isCurrentRoute('admin.tag.list') ? 'active' : '' }}">
                    <a href="{{ route('admin.tag.list') }}" class="menu-link">
                        <div>Tags</div>
                    </a>
                </li>

{{--                <li class="menu-item {{ isCurrentRoute('admin.tag.list') ? 'active' : '' }}">--}}
{{--                    <a href="{{ route('admin.tag.list') }}" class="menu-link">--}}
{{--                        <div>Tags</div>--}}
{{--                    </a>--}}
{{--                </li>--}}
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
                <li class="menu-item {{ isCurrentRoute('admin.forum-post.list') ? 'active' : '' }}">
                    <a href="{{ route('admin.forum-post.list') }}" class="menu-link">
                        <div>All Thread</div>
                    </a>
                </li>

                <li class="menu-item {{ isCurrentRoute('admin.forum-discussion.list') ? 'active' : '' }}">
                    <a href="{{ route('admin.forum-discussion.list') }}" class="menu-link">
                        <div>Forum Discussions</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
