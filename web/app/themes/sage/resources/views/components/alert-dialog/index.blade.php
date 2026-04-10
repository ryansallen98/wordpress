<x-alert-dialog.primitive.root
    data-slot="{{ $dataSlot }}"
    class="{{ $classes }}"
    :default-open="$defaultOpen"
    {{ $attributes->except(['class', 'default-open', 'defaultOpen']) }}
>
    {{ $slot }}
</x-alert-dialog.primitive.root>
