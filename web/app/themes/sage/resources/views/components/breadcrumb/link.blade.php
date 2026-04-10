<a
    data-slot="{{ $dataSlot }}"
    class="{{ $classes }}"
    href="{{ $href }}"
    {{ $attributes->except(['class', 'href', 'dataSlot']) }}
>
    {{ $slot }}
</a>
