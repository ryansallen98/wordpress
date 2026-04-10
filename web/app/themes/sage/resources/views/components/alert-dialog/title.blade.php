@props([
    'as' => 'h2',
    'dataSlot' => 'alert-dialog-title',
])
@php
    $classes = $tw->merge(
        'cn-font-heading text-base font-medium sm:group-data-[size=default]/alert-dialog-content:group-has-data-[slot=alert-dialog-media]/alert-dialog-content:col-start-2',
        $attributes->get('class')
    );
@endphp

<x-alert-dialog.primitive.title
    :as="$as"
    data-slot="{{ $dataSlot }}"
    {{ $attributes->except(['class', 'as', 'dataSlot']) }}
    class="{{ $classes }}"
>
    {{ $slot }}
</x-alert-dialog.primitive.title>
