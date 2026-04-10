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
