@props([
    'size' => 'default',
    'dataSlot' => 'alert-dialog-content',
    /** Tailwind duration segment (e.g. `duration-100`) — shared by portal `x-transition` and overlay/panel `tw-animate-css` so Alpine’s leave phase does not cut off exit keyframes. */
    'duration' => 'duration-100',
])
@php
    $overlayClasses = $tw->merge(
        "fixed inset-0 z-50 bg-black/10 {$duration} supports-backdrop-filter:backdrop-blur-xs data-[state=open]:animate-in data-[state=open]:fade-in-0 data-[state=closed]:animate-out data-[state=closed]:fade-out-0"
    );
    $panelClasses = $tw->merge(
        "group/alert-dialog-content fixed top-1/2 left-1/2 z-50 grid w-full -translate-x-1/2 -translate-y-1/2 gap-4 rounded-xl bg-popover p-4 text-popover-foreground ring-1 ring-foreground/10 {$duration} outline-none data-[size=default]:max-w-xs data-[size=sm]:max-w-xs data-[size=default]:sm:max-w-sm data-[state=open]:animate-in data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95 data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95",
        $attributes->get('class')
    );
@endphp

<x-alert-dialog.primitive.portal
    :enter-duration="$duration"
    :leave-duration="$duration"
>
    <x-alert-dialog.primitive.overlay class="{{ $overlayClasses }}" />
    <x-alert-dialog.primitive.content
        :size="$size"
        data-slot="{{ $dataSlot }}"
        class="{{ $panelClasses }}"
        {{ $attributes->except(['size', 'dataSlot', 'class', 'duration']) }}
    >
        {{ $slot }}
    </x-alert-dialog.primitive.content>
</x-alert-dialog.primitive.portal>
