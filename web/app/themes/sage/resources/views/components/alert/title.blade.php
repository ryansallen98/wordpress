<{{ $tag }}
    data-slot="{{ $dataSlot }}"
    class="{{ $classes }}"
    {{ $attributes->except('class') }}
>
    {{ $slot }}
</{{ $tag }}>
