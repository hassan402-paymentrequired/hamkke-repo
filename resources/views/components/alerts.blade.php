@if($errors->any())
    @foreach($errors->all() as $error)
        @component('components.alerts.error', ['alertMessage' => $error]) @endcomponent
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
            @component("components.alerts." . $status, ['alertMessage' => $msg]) @endcomponent
        @endif
    @endforeach
@endif
