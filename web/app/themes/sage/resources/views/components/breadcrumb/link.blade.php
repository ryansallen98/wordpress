@props([
    'href' => '#',
    'dataSlot' => 'breadcrumb-link',
])
@php
    $classes = $tw->merge(
        'text-muted-foreground no-underline! transition-colors hover:text-foreground',
        $attributes->get('class')
    );
@endphp

<a
    data-slot="{{ $dataSlot }}"
    class="{{ $classes }}"
    href="{{ $href }}"
    {{ $attributes->except(['class', 'href', 'dataSlot']) }}
>
    {{ $slot }}
</a>
