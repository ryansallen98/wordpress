<x-alert-dialog.primitive.description
    :as="$as"
    data-slot="{{ $dataSlot }}"
    {{ $attributes->except(['class', 'as', 'dataSlot']) }}
    class="{{ $classes }}"
>
    {{ $slot }}
</x-alert-dialog.primitive.description>
