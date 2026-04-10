<nav
    aria-label="{{ $label }}"
    data-slot="{{ $navDataSlot }}"
    {{ $attributes->except(['class', 'ariaLabel']) }}
>
    <ol data-slot="{{ $listDataSlot }}" class="{{ $listClasses }}">
        {{ $slot }}
    </ol>
</nav>
