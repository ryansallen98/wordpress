@props([
    'as' => 'span',
    'dataSlot' => 'alert-dialog-trigger',
])
@php
    $classes = $tw->merge($attributes->get('class'));
@endphp

<x-alert-dialog.primitive.trigger
    :as="$as"
    data-slot="{{ $dataSlot }}"
    {{ $attributes->except(['class', 'as', 'dataSlot']) }}
    class="{{ $classes }}"
>
    {{ $slot }}
</x-alert-dialog.primitive.trigger>
