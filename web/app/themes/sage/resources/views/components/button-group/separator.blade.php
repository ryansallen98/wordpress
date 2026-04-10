<div
    role="none"
    data-slot="{{ $dataSlot }}"
    data-orientation="{{ $orientationKey }}"
    class="{{ $classes }}"
    {{ $attributes->except(['class', 'orientation', 'dataSlot']) }}
></div>
