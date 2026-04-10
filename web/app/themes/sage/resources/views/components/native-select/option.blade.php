@props([
    'selected' => false,
    'dataSlot' => 'native-select-option',
])

@php
    $optionBase = 'bg-[Canvas] text-[CanvasText]';
    $optionClasses = $tw->merge($optionBase, $attributes->get('class'));
@endphp

<option
    data-slot="{{ $dataSlot }}"
    class="{{ $optionClasses }}"
    @selected($selected)
    {{ $attributes->except(['class', 'selected']) }}
>{{ $slot }}</option>
