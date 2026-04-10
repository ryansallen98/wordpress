@props([
    'as' => 'div',
    'dataSlot' => 'button-group-text',
])
@php
    $c = config('classes.button_group');
    $allowed = ['div', 'span', 'label'];
    $tag = in_array($as, $allowed, true) ? $as : 'div';
    $classes = $tw->merge($c['text']['base'], $attributes->get('class'));
@endphp

<{{ $tag }}
    data-slot="{{ $dataSlot }}"
    class="{{ $classes }}"
    {{ $attributes->except(['class', 'as', 'dataSlot']) }}
>
    {{ $slot }}
</{{ $tag }}>
