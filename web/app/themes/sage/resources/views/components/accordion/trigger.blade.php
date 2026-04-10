<x-accordion.primitive.trigger {{ $attributes->except('class') }} class="{{ $classes }}">
  {{ $slot }}
  <x-lucide-chevron-down
    data-slot="accordion-trigger-icon"
    class="pointer-events-none shrink-0 group-aria-expanded/accordion-trigger:hidden"
    aria-hidden="true"
  />
  <x-lucide-chevron-up
    data-slot="accordion-trigger-icon"
    class="pointer-events-none hidden shrink-0 group-aria-expanded/accordion-trigger:inline"
    aria-hidden="true"
  />
</x-accordion.primitive.trigger>
