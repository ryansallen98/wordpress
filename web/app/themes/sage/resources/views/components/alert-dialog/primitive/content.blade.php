@props([
    'size' => 'default',
    'dataSlot' => 'alert-dialog-content',
])

<div
    role="alertdialog"
    aria-modal="true"
    x-bind:aria-labelledby="$id('title')"
    x-bind:aria-describedby="$id('description')"
    x-bind:data-state="open ? 'open' : 'closed'"
    data-slot="{{ $dataSlot }}"
    data-size="{{ $size }}"
    {{ $attributes->except(['dataSlot', 'size', 'aria-labelledby', 'aria-describedby', 'data-state']) }}
>
    {{ $slot }}
</div>
