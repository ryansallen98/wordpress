<span
    data-slot="{{ $dataSlot }}"
    aria-current="page"
    class="{{ $classes }}"
    {{ $attributes->except(['class', 'dataSlot']) }}
>
    {{ $slot }}
</span>
