<div
    {{ $attributes->except([
        'data-slot',
    ]) }}
    data-slot="{{ $dataSlot }}"
    :id="`panel_${$id('acc')}`"
    role="region"
    :aria-labelledby="`acc_${$id('acc')}`"
    :data-state="isOpen($id('acc')) ? 'open' : 'closed'"
    :aria-hidden="!isOpen($id('acc'))"
    x-bind:inert="!isOpen($id('acc'))"
>
    {{ $slot }}
</div>
