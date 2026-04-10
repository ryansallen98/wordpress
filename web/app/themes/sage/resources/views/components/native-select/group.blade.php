<optgroup
    data-slot="{{ $dataSlot }}"
    class="{{ $groupClasses }}"
    label="{{ $label }}"
    @disabled($disabled)
    {{ $attributes->except(['class', 'label', 'disabled']) }}
>{{ $slot }}</optgroup>
