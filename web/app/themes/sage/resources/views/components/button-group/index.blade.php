@props([
    'orientation' => 'horizontal',
    'dataSlot' => 'button-group',
])
@php
    $c = config('classes.button_group');
    $orientationKey = in_array($orientation, ['horizontal', 'vertical'], true) ? $orientation : 'horizontal';
    $classes = $tw->merge(
        $c['group']['base'],
        $c['group']['orientation'][$orientationKey],
        $attributes->get('class')
    );
@endphp

<div
    role="group"
    data-slot="{{ $dataSlot }}"
    data-orientation="{{ $orientationKey }}"
    class="{{ $classes }}"
    {{ $attributes->except(['class', 'orientation', 'dataSlot']) }}
>
    {{ $slot }}
</div>
