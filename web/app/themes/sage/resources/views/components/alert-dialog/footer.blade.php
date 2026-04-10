@props([
    'dataSlot' => 'alert-dialog-footer',
])
@php
    $classes = $tw->merge(
        '-mx-4 -mb-4 flex flex-col-reverse gap-2 rounded-b-xl border-t bg-muted/50 p-4 group-data-[size=sm]/alert-dialog-content:grid group-data-[size=sm]/alert-dialog-content:grid-cols-2 sm:flex-row sm:justify-end',
        $attributes->get('class')
    );
@endphp

<div data-slot="{{ $dataSlot }}" class="{{ $classes }}" {{ $attributes->except('class') }}>
    {{ $slot }}
</div>
