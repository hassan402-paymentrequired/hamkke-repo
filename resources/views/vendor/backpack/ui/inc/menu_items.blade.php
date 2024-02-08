<li class="menu-item {{ isCurrentRoute('dashboard') ? 'active' : '' }}">
    <a href="{{ backpack_url('dashboard') }}" class="menu-link">
        <em class="menu-icon tf-icons ti ti-smart-home"></em>
        <div data-i18n="Dashboard">{{ trans('backpack::base.dashboard') }}</div>
    </a>
</li>
<x-backpack::menu-item title="Tags" icon="la la-question" :link="backpack_url('tags')" />
