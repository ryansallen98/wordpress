<div
  {{ $attributes->except('data-slot') }}
  data-slot="{{ $dataSlot }}"
  x-data="accordion({ type: @js($type) })"
>
  {{ $slot }}
</div>
