@props([
    'dataSlot' => 'breadcrumb-ellipsis',
])
@php
    $classes = $tw->merge(
        'flex size-9 items-center justify-center [&>svg]:size-4',
        $attributes->get('class')
    );
@endphp

<span
    data-slot="{{ $dataSlot }}"
    class="{{ $classes }}"
    {{ $attributes->except(['class', 'dataSlot']) }}
>
    <span class="sr-only">{{ __('More breadcrumbs', 'sage') }}</span>
    <x-lucide-more-horizontal class="shrink-0" aria-hidden="true" />
</span>
