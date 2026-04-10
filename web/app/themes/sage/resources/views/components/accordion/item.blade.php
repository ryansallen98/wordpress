<x-accordion.primitive.item
    :open="$open"
    {{ $attributes->except('class') }}
    class="{{ $classes }}"
>
  {{ $slot }}
</x-accordion.primitive.item>
