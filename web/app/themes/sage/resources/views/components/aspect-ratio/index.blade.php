{{-- ratio: square | 1 | 1/1, video | 16/9, or positive width/height e.g. 4/3 --}}
@props([
    'ratio' => '16/9',
    'dataSlot' => 'aspect-ratio',
])
@php
    $r = trim((string) $ratio);
    [$rw, $rh] = match (true) {
        in_array($r, ['1', '1/1', 'square'], true) => [1, 1],
        in_array($r, ['16/9', 'video'], true) => [16, 9],
        (bool) preg_match('/^\s*(\d+)\s*\/\s*(\d+)\s*$/', $r, $m) => [(int) $m[1], (int) $m[2]],
        default => [16, 9],
    };
    if ($rw < 1 || $rh < 1) {
        [$rw, $rh] = [16, 9];
    }
    $classes = $tw->merge(
        'relative w-full overflow-hidden',
        $attributes->get('class')
    );
@endphp

<div
    data-slot="{{ $dataSlot }}"
    data-ratio="{{ $rw }}/{{ $rh }}"
    class="{{ $classes }}"
    style="aspect-ratio: {{ $rw }} / {{ $rh }}"
    {{ $attributes->except(['class', 'dataSlot', 'ratio', 'style']) }}
>
    {{ $slot }}
</div>
