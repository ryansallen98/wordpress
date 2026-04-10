@props([
    'ariaLabel' => null,
    'navDataSlot' => 'breadcrumbs',
    'listDataSlot' => 'breadcrumb-list',
])
@php
    $label = $ariaLabel ?? __('Breadcrumbs', 'sage');
    $listClasses = $tw->merge(
        'm-0 flex list-none flex-wrap items-center gap-1.5 break-words text-sm text-muted-foreground',
        $attributes->get('class')
    );
@endphp

<nav
    aria-label="{{ $label }}"
    data-slot="{{ $navDataSlot }}"
    {{ $attributes->except(['class', 'ariaLabel']) }}
>
    <ol data-slot="{{ $listDataSlot }}" class="{{ $listClasses }}">
        {{ $slot }}
    </ol>
</nav>
