<div
  data-slot="{{ $dataSlot }}"
  role="{{ $role }}"
  class="{{ $classes }}"
  {{ $attributes->except('class') }}
>
  {{ $slot }}
</div>
