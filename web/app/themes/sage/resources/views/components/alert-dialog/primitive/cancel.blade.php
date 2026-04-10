<button
    type="button"
    data-slot="{{ $dataSlot }}"
    x-on:click="{!! $mergedClick !!}"
    {{ $passthrough->except(['x-on:click', 'dataSlot']) }}
>
    {{ $slot }}
</button>
