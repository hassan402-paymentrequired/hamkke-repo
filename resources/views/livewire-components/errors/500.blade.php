<x-error-layout title="{{ __('Server Error | Its not you it\'s me 🙏🏽! :(') }}">
    <x-slot name="message">{{ __(auth('web')->check() ? $message : 'An Internal server error occurred') }}</x-slot>
    <x-slot name="image">{{ asset('cms-assets/illustrations/page-misc-error.png') }}</x-slot>
</x-error-layout>
