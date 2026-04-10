<div
    aria-hidden="true"
    x-bind:data-state="open ? 'open' : 'closed'"
    data-slot="{{ $dataSlot }}"
    {{ $attributes->except(['dataSlot', 'aria-hidden', 'data-state']) }}
></div>
