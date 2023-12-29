<ul class="nav nav-pills flex-column flex-md-row mb-4">
    <li class="nav-item">
        <a class="nav-link {{ isCurrentRoute('settings.user_profile') ? 'active': '' }}" href="{{ route('settings.general') }}">
            <i class="ti-xs ti ti-lock me-1"></i> Account
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ isCurrentRoute('settings.general') ? 'active': '' }}" href="{{ route('settings.general') }}">
            <i class="ti-xs ti ti-lock me-1"></i> General Settings
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link {{ isCurrentRoute('settings.general') ? 'active', ''}}" href="pages-account-settings-notifications.html">
            <i class="ti-xs ti ti-bell me-1"></i> Notifications
        </a>
    </li> --}}
</ul>
