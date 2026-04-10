<x-alert-dialog.primitive.title
    :as="$as"
    data-slot="{{ $dataSlot }}"
    {{ $attributes->except(['class', 'as', 'dataSlot']) }}
    class="{{ $classes }}"
>
    {{ $slot }}
</x-alert-dialog.primitive.title>
