<div
    data-slot="{{ $dataSlot }}"
    data-mode="{{ $modeKey }}"
    @if ($nMonths > 1) data-multiple-months="true" @endif
    x-data="calendar(@js($calConfig))"
    class="{{ $tw->merge($rootClass, $attributes->get('class') ?? '') }}"
    x-on:keydown="onGridKeydown($event)"
    x-on:focusin="onGridFocusin($event)"
    {{ $attributes->except('class') }}
>
  <div class="{{ $c['months'] }}">
      {{-- Nav spans full multi-month width (shadcn / RDP: sibling of .rdp-month, not inside first month). --}}
      <span class="sr-only absolute top-0 left-0 -m-px h-px w-px overflow-hidden border-0 p-0 whitespace-nowrap" aria-live="polite" x-text="monthLabel"></span>
      <nav class="{{ $c['nav'] }}" aria-label="{{ esc_attr__('Calendar month navigation', 'sage') }}">
        <x-button.icon
          type="button"
          variant="ghost"
          size="sm"
          class="{{ $c['button_nav'] }} calendar-nav-prev rtl:**:[&>svg]:rotate-180"
          x-on:click="prevMonth()"
          x-bind:disabled="!canPrev()"
          x-bind:aria-disabled="canPrev() ? 'false' : 'true'"
          aria-label="{{ esc_attr__('Previous month', 'sage') }}"
        >
          <x-lucide-chevron-left class="size-4" aria-hidden="true" />
        </x-button.icon>
        <x-button.icon
          type="button"
          variant="ghost"
          size="sm"
          class="{{ $c['button_nav'] }} calendar-nav-next rtl:**:[&>svg]:rotate-180"
          x-on:click="nextMonth()"
          x-bind:disabled="!canNext()"
          x-bind:aria-disabled="canNext() ? 'false' : 'true'"
          aria-label="{{ esc_attr__('Next month', 'sage') }}"
        >
          <x-lucide-chevron-right class="size-4" aria-hidden="true" />
        </x-button.icon>
      </nav>
      <template x-for="(monthWeeks, mi) in weeksByMonth" :key="mi">
        <div class="{{ $c['month'] }}">
          {{-- First panel only: caption (dropdown or label); prev/next live on .months. --}}
          <template x-if="mi === 0">
            <div class="{{ $c['month_toolbar'] }}">
            <div class="{{ $c['month_caption'] }}" x-show="captionLayout === 'dropdown'">
              <x-native-select
                size="sm"
                class="{{ $c['caption_select_month_wrapper'] }}"
                select-class="{{ $c['caption_select'] }}"
                icon-class="{{ $c['caption_select_icon'] }}"
                wrapper-data-slot="calendar-caption-month"
                select-data-slot="calendar-caption-month-select"
                icon-data-slot="calendar-caption-month-icon"
                x-bind:value="String(captionMonth())"
                x-on:change="onCaptionMonthChange($event)"
                aria-label="{{ esc_attr__('Month', 'sage') }}"
              >
                @foreach ($captionMonthChoices as $mc)
                  <option
                    value="{{ $mc['value'] }}"
                    class="bg-[Canvas] text-[CanvasText]"
                    data-slot="native-select-option"
                    x-bind:disabled="isCaptionMonthDisabled({{ $mc['value'] }})"
                  >{{ $mc['label'] }}</option>
                @endforeach
              </x-native-select>
              <x-native-select
                size="sm"
                class="{{ $c['caption_select_year_wrapper'] }}"
                select-class="{{ $c['caption_select'] }}"
                icon-class="{{ $c['caption_select_icon'] }}"
                wrapper-data-slot="calendar-caption-year"
                select-data-slot="calendar-caption-year-select"
                icon-data-slot="calendar-caption-year-icon"
                x-bind:value="String(captionYear())"
                x-on:change="onCaptionYearChange($event)"
                aria-label="{{ esc_attr__('Year', 'sage') }}"
              >
                @foreach ($captionYears as $captionYear)
                  <option
                    value="{{ $captionYear }}"
                    class="bg-[Canvas] text-[CanvasText]"
                    data-slot="native-select-option"
                  >{{ $captionYear }}</option>
                @endforeach
              </x-native-select>
            </div>
            <div class="{{ $c['month_caption'] }}" x-show="captionLayout === 'label'">
              <span class="{{ $c['caption_label'] }}" x-show="numberOfMonths <= 1" x-text="monthLabel"></span>
              <span class="{{ $c['caption_label'] }}" x-show="numberOfMonths > 1" x-text="panelMonthLabel(0)"></span>
            </div>
            </div>
          </template>

          <div
            class="{{ $c['month_subcaption'] }}"
            x-show="mi > 0 && numberOfMonths > 1"
            x-text="panelMonthLabel(mi)"
          ></div>

          <div
            role="grid"
            class="{{ $c['grid'] }}"
            :aria-label="panelGridLabel(mi)"
            aria-readonly="true"
            @if ($modeKey === 'range') aria-multiselectable="true" @else aria-multiselectable="false" @endif
          >
            <div role="row" class="{{ $c['weekdays_row'] }}">
              <template x-for="(label, i) in weekdayLabels" :key="i">
                <div role="columnheader" class="{{ $c['weekday'] }}" x-text="label"></div>
              </template>
            </div>
            <template x-for="(week, wi) in monthWeeks" :key="wi">
              <div role="row" class="{{ $c['week_row'] }}">
                <template x-for="cell in week" :key="cell.iso">
                  <div
                    :role="cell.padding ? 'presentation' : 'gridcell'"
                    :aria-hidden="cell.padding ? 'true' : null"
                    :data-selected="cell.padding ? 'false' : (cellSelected(cell) ? 'true' : 'false')"
                    :data-modifiers="cell.padding ? '' : cell.modifierKeys.join(' ')"
                    :class="tdClass(cell)"
                  >
                    <template x-if="!cell.padding">
                      <button
                        type="button"
                        class="{{ $tw->merge($c['day_button']) }}"
                        :disabled="cell.disabled"
                        :tabindex="dayTabindex(cell)"
                        :data-day="cell.iso"
                        :data-selected-single="cell.selectedSingle ? 'true' : 'false'"
                        :data-range-start="cell.rangeStart ? 'true' : 'false'"
                        :data-range-end="cell.rangeEnd ? 'true' : 'false'"
                        :data-range-middle="cell.rangeMiddle ? 'true' : 'false'"
                        :aria-label="dayAriaLabel(cell.iso)"
                        :aria-selected="cellSelected(cell) ? 'true' : 'false'"
                        :aria-current="cell.today ? 'date' : null"
                        x-on:click="selectCell(cell)"
                        x-text="cell.label"
                      ></button>
                    </template>
                  </div>
                </template>
              </div>
            </template>
          </div>
        </div>
      </template>
  </div>
</div>
