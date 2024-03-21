@extends('layouts.frontend.front-app', ['pageTitle' => $title])

@section('content')
    {{ $slot }}
@endsection

@section('more-scripts')
    {{ $more_scripts_slot ?? '' }}
@stop
