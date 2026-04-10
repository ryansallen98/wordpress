@props([
    'label' => '',
    'disabled' => false,
    'dataSlot' => 'native-select-optgroup',
])

@php
    $optgroupBase = 'bg-[Canvas] text-[CanvasText]';
    $groupClasses = $tw->merge($optgroupBase, $attributes->get('class'));
@endphp

<optgroup
    data-slot="{{ $dataSlot }}"
    class="{{ $groupClasses }}"
    label="{{ $label }}"
    @disabled($disabled)
    {{ $attributes->except(['class', 'label', 'disabled']) }}
>{{ $slot }}</optgroup>
