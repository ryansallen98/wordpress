<span
    data-slot="{{ $dataSlot }}"
    class="{{ $classes }}"
    {{ $attributes->except(['class', 'dataSlot']) }}
>
    <span class="sr-only">{{ __('More breadcrumbs', 'sage') }}</span>
    <x-lucide-more-horizontal class="shrink-0" aria-hidden="true" />
</span>
