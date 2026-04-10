<x-alert-dialog.primitive.action
    data-slot="{{ $dataSlot }}"
    class="{{ $classes }}"
    data-variant="{{ $variant }}"
    data-size="{{ $size }}"
    {{ $attributes->except(['class', 'variant', 'size', 'dataSlot']) }}
>
    {{ $slot }}
</x-alert-dialog.primitive.action>
