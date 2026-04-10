<option
    data-slot="{{ $dataSlot }}"
    class="{{ $optionClasses }}"
    @selected($selected)
    {{ $attributes->except(['class', 'selected']) }}
>{{ $slot }}</option>
