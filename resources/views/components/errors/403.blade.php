<x-errors.layout title="{{ __('Unauthorized') }}">
    <x-slot name="message">{{ __($message ?? 'You do not have permission to view this page using the credentials that you have provided while login.
Please contact your site administrator.') }}</x-slot>
</x-errors.layout>
