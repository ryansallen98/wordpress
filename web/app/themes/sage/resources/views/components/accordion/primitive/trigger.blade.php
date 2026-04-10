@props([
  'level' => 3,
  'dataSlot' => 'accordion-trigger',
])

<h{{ $level }} 
  class="flex"
  :data-state="isOpen($id('acc')) ? 'open' : 'closed'"
>
  <button
    data-slot="{{ $dataSlot }}"
    data-level="{{ $level }}"
    {{ $attributes->except([
      'data-slot',
      'level',
    ]) }}
    type="button"
    :id="`acc_${$id('acc')}`"
    :aria-controls="`panel_${$id('acc')}`"
    :aria-expanded="isOpen($id('acc'))"
    :data-state="isOpen($id('acc')) ? 'open' : 'closed'"
    x-on:click="toggle($id('acc'))"
    x-on:keydown.arrow-down.prevent="moveFocus(1, $el)"
    x-on:keydown.arrow-up.prevent="moveFocus(-1, $el)"
    x-on:keydown.home.prevent="focusList[0]?.focus()"
    x-on:keydown.end.prevent="focusList[focusList.length-1]?.focus()"
    x-init="registerTrigger($el)"
  >
    {{ $slot }}
  </button>
</h{{ $level }}>