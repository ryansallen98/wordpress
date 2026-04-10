{{-- ratio: square | 1 | 1/1, video | 16/9, or positive width/height e.g. 4/3 --}}
<div
    data-slot="{{ $dataSlot }}"
    data-ratio="{{ $rw }}/{{ $rh }}"
    class="{{ $classes }}"
    style="aspect-ratio: {{ $rw }} / {{ $rh }}"
    {{ $attributes->except(['class', 'dataSlot', 'ratio', 'style']) }}
>
    {{ $slot }}
</div>
