<{{ $tag }}
    data-slot="{{ $dataSlot }}"
    class="{{ $classes }}"
    {{ $attributes->except(['class', 'as', 'dataSlot']) }}
>
    {{ $slot }}
</{{ $tag }}>
