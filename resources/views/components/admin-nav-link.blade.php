@props(['routeName', 'icon', 'linkText'])
@php
    /**
     * @var \App\Models\User $authUser
     * @var \App\Models\Permission[]|\Illuminate\Database\Eloquent\Collection $allPermissions
     */
@endphp
@if($allPermissions->where('name', $routeName)->isEmpty() || $authUser->can($routeName))
    <li class="menu-item {{ isCurrentRoute($routeName) ? 'active' : '' }}">
        <a href="{{ route($routeName) }}" class="menu-link">
            @if($icon ?? false)
            <em class="menu-icon tf-icons ti {{ $icon }}"></em>
            @endif
            <div data-i18n="{{ $linkText }}">{{ $linkText }}</div>
        </a>
    </li>
@endif
