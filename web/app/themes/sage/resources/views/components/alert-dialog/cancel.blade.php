<x-alert-dialog.primitive.cancel
    :autofocus="$autofocus"
    data-slot="{{ $dataSlot }}"
    class="{{ $classes }}"
    data-variant="{{ $variant }}"
    data-size="{{ $size }}"
    {{ $attributes->except(['class', 'autofocus', 'variant', 'size', 'dataSlot']) }}
>
    {{ $slot }}
</x-alert-dialog.primitive.cancel>
