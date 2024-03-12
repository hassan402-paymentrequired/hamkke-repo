@extends('layouts.app', ['pageTitle' => $title])

@section('main-content')
    {{ $slot }}
@endsection

@section('more-scripts')
    {{ $more_scripts_slot ?? '' }}
@stop
