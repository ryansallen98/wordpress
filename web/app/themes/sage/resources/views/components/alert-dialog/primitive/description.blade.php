@props([
    'as' => 'p',
    'dataSlot' => 'alert-dialog-description',
])
@php
    $tag = $as;
@endphp

<{{ $tag }}
    data-slot="{{ $dataSlot }}"
    x-bind:id="$id('description')"
    {{ $attributes }}
>
    {{ $slot }}
</{{ $tag }}>
