@props([
    'orientation' => 'vertical',
    'dataSlot' => 'button-group-separator',
])
@php
    $c = config('classes.button_group');
    $orientationKey = in_array($orientation, ['horizontal', 'vertical'], true) ? $orientation : 'vertical';
    $classes = $tw->merge(
        $c['separator']['radix'],
        $c['separator']['group'],
        $attributes->get('class')
    );
@endphp

<div
    role="none"
    data-slot="{{ $dataSlot }}"
    data-orientation="{{ $orientationKey }}"
    class="{{ $classes }}"
    {{ $attributes->except(['class', 'orientation', 'dataSlot']) }}
></div>
