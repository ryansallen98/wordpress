<div
    role="group"
    data-slot="{{ $dataSlot }}"
    data-orientation="{{ $orientationKey }}"
    class="{{ $classes }}"
    {{ $attributes->except(['class', 'orientation', 'dataSlot']) }}
>
    {{ $slot }}
</div>
