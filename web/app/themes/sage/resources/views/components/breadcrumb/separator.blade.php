<li
    data-slot="{{ $dataSlot }}"
    role="presentation"
    aria-hidden="true"
    class="{{ $classes }}"
    {{ $attributes->except(['class', 'dataSlot']) }}
>
    @if (isset($slot) && ! $slot->isEmpty())
        {{ $slot }}
    @else
        <x-lucide-chevron-right aria-hidden="true" />
    @endif
</li>
