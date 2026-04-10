<div data-slot="{{ $wrapperDataSlot }}" data-size="{{ $size }}" class="{{ $wrapperClasses }}">
    <select
        data-slot="{{ $selectDataSlot }}"
        data-size="{{ $size }}"
        class="{{ $selectClasses }}"
        {{ $attributes }}
    >{{ $slot }}</select>
    <x-lucide-chevron-down class="{{ $iconClasses }}" aria-hidden="true" data-slot="{{ $iconDataSlot }}" />
</div>
