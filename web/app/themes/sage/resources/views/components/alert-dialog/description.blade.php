@props([
    'as' => 'p',
    'dataSlot' => 'alert-dialog-description',
])
@php
    $classes = $tw->merge(
        'text-sm text-balance text-muted-foreground md:text-pretty *:[a]:underline *:[a]:underline-offset-3 *:[a]:hover:text-foreground',
        $attributes->get('class')
    );
@endphp

<x-alert-dialog.primitive.description
    :as="$as"
    data-slot="{{ $dataSlot }}"
    {{ $attributes->except(['class', 'as', 'dataSlot']) }}
    class="{{ $classes }}"
>
    {{ $slot }}
</x-alert-dialog.primitive.description>
