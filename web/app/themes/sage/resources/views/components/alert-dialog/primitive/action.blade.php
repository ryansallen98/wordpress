<button
    type="{{ $type }}"
    data-slot="{{ $dataSlot }}"
    x-on:click="{!! $mergedClick !!}"
    {{ $attributes->except(['x-on:click', 'dataSlot', 'type']) }}
>
    {{ $slot }}
</button>
