<li class="menu-item">
    <a href="{{ $link }}" class="menu-link">
        <em class="menu-icon {{ $icon ?: 'tf-icons ti ti-question' }}"></em>
            @if ($title != null)<div data-i18n>{{ $title }}</div> @endif
    </a>
</li>
