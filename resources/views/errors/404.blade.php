<x-errors.layout title="{{ __('Page Not Found :(') }}">
    <x-slot name="message">{{ __($message ?? 'Oops! 😖 The requested URL was not found on this server. uuuuuuuu') }}</x-slot>
    <x-slot name="image">{{ asset('cms-assets/illustrations/page-misc-error.png') }}</x-slot>
</x-errors.layout>
