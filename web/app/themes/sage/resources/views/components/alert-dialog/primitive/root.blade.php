@props([
    'defaultOpen' => false,
    'dataSlot' => 'alert-dialog',
])

<div
    data-slot="{{ $dataSlot }}"
    x-data="alertDialog({ defaultOpen: @js($defaultOpen) })"
    x-id="['title', 'description']"
    {{ $attributes->except(['dataSlot', 'defaultOpen', 'default-open']) }}
>
    {{ $slot }}
</div>
