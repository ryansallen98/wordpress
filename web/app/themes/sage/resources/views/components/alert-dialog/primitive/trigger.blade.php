@if ($bladeComponent !== null)
    <x-dynamic-component
        :component="$bladeComponent"
        data-slot="{{ $dataSlot }}"
        type="button"
        x-on:click="openDialog()"
        {{ $attributes->except(['as']) }}
    >
        {{ $slot }}
    </x-dynamic-component>
@else
    <{{ $tag }}
        data-slot="{{ $dataSlot }}"
        @if ($tag === 'button')
            type="button"
        @endif
        x-on:click="openDialog()"
        {{ $attributes->except(['as']) }}
    >
        {{ $slot }}
    </{{ $tag }}>
@endif
