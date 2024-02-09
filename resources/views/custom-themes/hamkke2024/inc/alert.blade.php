@if($errors->any())
    @foreach($errors->all() as $error)
        @include(backpack_view('components.alerts.error'))
    @endforeach
@endif
@php
    $alertStatuses = $alertStatuses ?? ['error', 'warning', 'success', 'info'];
    $sessionKeys = array_keys(session()->all());
    $statusesInSession = array_intersect($sessionKeys, $alertStatuses);
@endphp
@if(!empty($statusesInSession))
    @foreach ($statusesInSession as $status)
        @if($msg = Session::get($status))
            @include(backpack_view("components.alerts." . $status))
        @endif
    @endforeach
@endif
