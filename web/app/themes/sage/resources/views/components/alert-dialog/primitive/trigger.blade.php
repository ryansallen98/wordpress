@props([
    'as' => 'span',
    'dataSlot' => 'alert-dialog-trigger',
])

@php
    // `as="x-{component}"` → same component name as in markup (`x-button` → `button`, `x-button.icon` → `button.icon`).
    $bladeComponent = str_starts_with($as, 'x-') ? substr($as, 2) : null;
    $nativeTags = ['button', 'a', 'span'];
    $tag = $bladeComponent === null && in_array($as, $nativeTags, true) ? $as : 'span';
@endphp

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
