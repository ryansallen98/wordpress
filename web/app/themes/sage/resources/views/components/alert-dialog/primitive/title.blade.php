@props([
    'as' => 'h2',
    'dataSlot' => 'alert-dialog-title',
])
@php
    $tag = $as;
@endphp

<{{ $tag }}
    data-slot="{{ $dataSlot }}"
    x-bind:id="$id('title')"
    {{ $attributes }}
>
    {{ $slot }}
</{{ $tag }}>
