<div
  {{ $attributes->except([
    'data-slot',
    'open',
  ]) }}
  data-slot="{{ $dataSlot }}"
  role="group"
  x-id="['acc']"
  :data-state="isOpen($id('acc')) ? 'open' : 'closed'"
  @if($open) x-init="toggle($id('acc'))" @endif
>
  {{ $slot }}
</div>
