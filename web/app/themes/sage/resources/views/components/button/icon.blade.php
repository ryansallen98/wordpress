<{{ $tag }}
    data-slot="{{ $dataSlot }}"
    data-variant="{{ $variant }}"
    data-size="{{ $size }}"
    class="{{ $classes }}"
    {{ $attributes->except('class') }}
>
  {{ $slot }}
</{{ $tag }}>
