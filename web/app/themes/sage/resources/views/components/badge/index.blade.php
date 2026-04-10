<{{ $tag }}
    data-slot="{{ $dataSlot }}"
    data-variant="{{ $variant }}"
    class="{{ $classes }}"
    {{ $attributes->except('class') }}
>
  {{ $slot }}
</{{ $tag }}>
