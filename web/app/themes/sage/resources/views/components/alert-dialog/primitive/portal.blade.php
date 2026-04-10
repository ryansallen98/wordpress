<template x-teleport="body">
    <div
        x-show="open"
        x-transition:enter="motion-safe:transition-opacity motion-safe:{{ $enterDuration }}"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="motion-safe:transition-opacity motion-safe:{{ $leaveDuration }}"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-trap.noscroll.inert="open"
        x-cloak
        class="fixed inset-0 z-50"
        data-slot="{{ $dataSlot }}"
        {{ $attributes->except(['dataSlot', 'enterDuration', 'leaveDuration']) }}
        x-on:keydown.escape.window.prevent="open && closeDialog()"
    >
        {{ $slot }}
    </div>
</template>
