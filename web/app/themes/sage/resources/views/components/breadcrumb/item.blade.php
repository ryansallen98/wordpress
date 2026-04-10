<li data-slot="{{ $dataSlot }}" class="{{ $classes }}" {{ $attributes->except(['class', 'dataSlot']) }}>
    {{ $slot }}
</li>
