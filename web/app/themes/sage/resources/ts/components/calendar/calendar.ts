import {
  addMonths,
  endOfMonth,
  format,
  isAfter,
  isBefore,
  isSameMonth,
  isValid,
  parseISO,
  startOfMonth,
  subMonths,
  type Locale,
} from 'date-fns';
import { enUS } from 'date-fns/locale/en-US';

import {
  buildCalendarWeeks,
  buildWeekdayLabels,
  type CalendarCell,
  type CalendarMode,
} from './calendar_grid';
import {
  parseCalendarIsoList,
  parseCalendarModifierGroups,
  parseModifiersClassNames,
} from './calendar_modifiers';
import {
  type CalendarLocaleId,
  CALENDAR_DEFAULT_LOCALE_ID,
  loadCalendarLocale,
  normalizeCalendarLocaleId,
} from './calendar_locales';
import { getTodayIsoInTimeZone } from './calendar_timezone';

export function flattenCalendarWeeks(weeks: CalendarCell[][]): CalendarCell[] {
  return weeks.flat();
}

/** Whether a calendar can show this month (any overlap with [min, max] when set). */
export function monthCanDisplayCalendarView(
  monthStart: Date,
  min: Date | null,
  max: Date | null
): boolean {
  const mStart = startOfMonth(monthStart);
  const mEnd = endOfMonth(mStart);
  if (min && isBefore(mEnd, startOfMonth(min))) {
    return false;
  }
  if (max && isAfter(mStart, endOfMonth(max))) {
    return false;
  }
  return true;
}

/** Whether `count` consecutive months starting at `anchorFirstMonth` are each displayable. */
export function monthsSpanCanDisplay(
  anchorFirstMonth: Date,
  count: number,
  min: Date | null,
  max: Date | null
): boolean {
  const anchor = startOfMonth(anchorFirstMonth);
  const n = Math.max(1, Math.floor(count));
  for (let i = 0; i < n; i++) {
    if (!monthCanDisplayCalendarView(addMonths(anchor, i), min, max)) {
      return false;
    }
  }
  return true;
}

export function isDateInVisibleMonthSpan(
  d: Date,
  visibleAnchor: Date,
  numberOfMonths: number
): boolean {
  const n = Math.max(1, Math.floor(numberOfMonths));
  for (let i = 0; i < n; i++) {
    if (isSameMonth(d, addMonths(startOfMonth(visibleAnchor), i))) {
      return true;
    }
  }
  return false;
}

/** Inclusive year list for caption `<select>`; always includes `visibleYear`. */
export function buildCalendarYearOptions(
  visibleYear: number,
  min: Date | null,
  max: Date | null,
  pad = 50
): number[] {
  let lo = min ? min.getFullYear() : visibleYear - pad;
  let hi = max ? max.getFullYear() : visibleYear + pad;
  if (!min && visibleYear < lo) {
    lo = visibleYear;
  }
  if (!max && visibleYear > hi) {
    hi = visibleYear;
  }
  const out: number[] = [];
  for (let y = lo; y <= hi; y++) {
    out.push(y);
  }
  return out;
}

export function isCalendarCaptionMonthDisabled(
  year: number,
  month1to12: number,
  min: Date | null,
  max: Date | null
): boolean {
  const start = startOfMonth(new Date(year, month1to12 - 1, 1));
  return !monthCanDisplayCalendarView(start, min, max);
}

/**
 * First paint month: `selected` wins (single/range anchor) so grid and caption match the selection;
 * else explicit `month`; else today. Mirrors `calendar/index.blade.php`.
 */
export function resolveInitialCalendarVisibleMonth(opts: {
  visibleMonth?: string | null | undefined;
  selected?: string | null | undefined;
}): Date {
  const sel = opts.selected;
  if (sel != null && String(sel).trim() !== '') {
    const d = parseISO(String(sel));
    if (isValid(d)) {
      return startOfMonth(d);
    }
  }
  const vm = opts.visibleMonth;
  if (vm != null && String(vm).trim() !== '') {
    const d = parseISO(String(vm));
    if (isValid(d)) {
      return startOfMonth(d);
    }
  }
  return startOfMonth(new Date());
}

/**
 * Roving-focus target for Arrow/Home/End within the visible grid (disabled days skipped).
 * PageUp/PageDown are handled on the component (change month).
 */
export function moveCalendarKeyboardFocus(
  weeks: CalendarCell[][],
  fromIso: string,
  key: string
): string | null {
  const flat = flattenCalendarWeeks(weeks);
  const i = flat.findIndex((c) => c.iso === fromIso);
  if (i === -1) {
    return null;
  }

  const scanLinear = (start: number, step: number): string | null => {
    let j = start;
    while (j >= 0 && j < flat.length) {
      const cell = flat[j];
      if (cell && !cell.disabled) {
        return cell.iso;
      }
      j += step;
    }
    return null;
  };

  switch (key) {
    case 'ArrowLeft':
      return scanLinear(i - 1, -1);
    case 'ArrowRight':
      return scanLinear(i + 1, 1);
    case 'ArrowUp':
      return scanLinear(i - 7, -7);
    case 'ArrowDown':
      return scanLinear(i + 7, 7);
    case 'Home': {
      const rowStart = Math.floor(i / 7) * 7;
      return scanLinear(rowStart, 1);
    }
    case 'End': {
      const rowStart = Math.floor(i / 7) * 7;
      return scanLinear(rowStart + 6, -1);
    }
    default:
      return null;
  }
}

/** First enabled in-month cell for `dayOfMonth`, or null. */
export function pickIsoForDayOfMonthInMonth(
  weeks: CalendarCell[][],
  dayOfMonth: number
): string | null {
  for (const c of flattenCalendarWeeks(weeks)) {
    if (c.disabled || c.outside) {
      continue;
    }
    if (parseISO(c.iso).getDate() === dayOfMonth) {
      return c.iso;
    }
  }
  return null;
}

export function pickInitialCalendarFocusIso(
  weeks: CalendarCell[][],
  opts: {
    mode: CalendarMode;
    selectedIso: string | null;
    rangeFromIso: string | null;
    /** Calendar “today” ISO; defaults to local `yyyy-MM-dd`. */
    todayIso?: string;
  }
): string | null {
  const flat = flattenCalendarWeeks(weeks);
  const firstEnabled = flat.find((c) => !c.disabled);
  if (!firstEnabled) {
    return null;
  }

  const prefer =
    opts.mode === 'single' && opts.selectedIso
      ? opts.selectedIso
      : opts.mode === 'range' && opts.rangeFromIso
        ? opts.rangeFromIso
        : null;
  if (prefer) {
    const hit = flat.find((c) => c.iso === prefer && !c.disabled);
    if (hit) {
      return hit.iso;
    }
  }

  const todayIso = opts.todayIso ?? format(new Date(), 'yyyy-MM-dd');
  const todayCell = flat.find((c) => c.iso === todayIso && !c.disabled);
  if (todayCell) {
    return todayCell.iso;
  }

  return firstEnabled.iso;
}

export interface CalendarThemeClasses {
  dayTd: string;
  rangeStart: string;
  rangeMiddle: string;
  rangeEnd: string;
  today: string;
  outside: string;
  disabled: string;
}

export type CalendarCaptionLayout = 'dropdown' | 'label';

export interface CalendarAlpineOpts {
  mode?: CalendarMode;
  weekStartsOn?: 0 | 1;
  showOutsideDays?: boolean;
  visibleMonth?: string;
  selected?: string | null;
  min?: string | null;
  max?: string | null;
  /** BCP 47 tag (e.g. `fr`, `en-GB`); see `calendar_locales.ts` whitelist. */
  locale?: string | null;
  /** Consecutive months to show (1–12). Nav advances one month at a time. */
  numberOfMonths?: number;
  /** `dropdown` = month/year `<select>`s (single month only; 2+ months use `label`). */
  captionLayout?: CalendarCaptionLayout;
  /** IANA zone (e.g. `America/New_York`) for which calendar day is “today”; empty = browser local. */
  timeZone?: string | null;
  /** ISO `yyyy-MM-dd` dates that are not selectable (merged with min/max). */
  disabled?: string[] | unknown;
  /** Named groups of ISO dates for styling (`modifiersClassNames`). */
  modifiers?: Record<string, unknown> | unknown;
  /** Tailwind classes per modifier name (often on `<td>`, e.g. `[&>button]:line-through`). */
  modifiersClassNames?: Record<string, string> | unknown;
  themeClasses?: CalendarThemeClasses;
}

export interface CalendarAlpineState {
  mode: CalendarMode;
  weekStartsOn: 0 | 1;
  showOutsideDays: boolean;
  numberOfMonths: number;
  captionLayout: CalendarCaptionLayout;
  timeZone: string | null;
  /** Resolved locale id (whitelist); drives async `dfLocale` load. */
  localeId: CalendarLocaleId;
  /** date-fns locale for `format()` (weekday headers, live region, day `aria-label`). */
  dfLocale: Locale;
  weekdayLabels: string[];
  visibleMonth: Date;
  selectedSingle: Date | null;
  rangeFrom: Date | null;
  rangeTo: Date | null;
  /** One grid per month; keyboard uses `weeks` (all rows concatenated). */
  weeksByMonth: CalendarCell[][][];
  weeks: CalendarCell[][];
  monthLabel: string;
  /** Local `yyyy-MM-dd` used when no IANA zone; else zone’s calendar today. */
  resolvedTodayIso: string;
  modifierClassByKey: Record<string, string>;
  themeClasses: CalendarThemeClasses;
  /** Roving tabindex target (ISO day); one day button uses tabindex 0. */
  focusedIso: string | null;
  init(): void;
  refresh(): void;
  reconcileFocus(opts?: { preferDayOfMonth?: number }): void;
  navigateToVisibleMonth(nextMonthStart: Date): void;
  prevMonth(): void;
  nextMonth(): void;
  canPrev(): boolean;
  canNext(): boolean;
  captionMonth(): number;
  captionYear(): number;
  isCaptionMonthDisabled(month1to12: number): boolean;
  onCaptionMonthChange(event: Event): void;
  onCaptionYearChange(event: Event): void;
  panelMonthLabel(monthIndex: number): string;
  panelGridLabel(monthIndex: number): string;
  cellSelected(cell: CalendarCell): boolean;
  tdClass(cell: CalendarCell): string;
  dayAriaLabel(iso: string): string;
  dayTabindex(cell: CalendarCell): 0 | -1;
  selectCell(cell: CalendarCell): void;
  onGridFocusin(event: FocusEvent): void;
  onGridKeydown(event: KeyboardEvent): void;
  focusDayButton(iso: string): void;
}

type CalendarComponentThis = CalendarAlpineState & {
  $el: HTMLElement;
  $nextTick: (cb: () => void) => void;
};

function activeDayButtonInCalendarRoot(root: HTMLElement | null): boolean {
  if (!root) {
    return false;
  }
  const a = document.activeElement;
  return a instanceof HTMLButtonElement && root.contains(a) && a.hasAttribute('data-day');
}

export function calendar(opts: CalendarAlpineOpts = {}): CalendarAlpineState {
  const minIso = opts.min ?? null;
  const maxIso = opts.max ?? null;
  const weekStartsOn = (opts.weekStartsOn === 1 ? 1 : 0) as 0 | 1;
  const showOutsideDays = opts.showOutsideDays !== false;
  const mode = opts.mode === 'range' ? 'range' : 'single';

  const minDate = minIso ? parseISO(minIso) : null;
  const maxDate = maxIso ? parseISO(maxIso) : null;
  const localeId = normalizeCalendarLocaleId(opts.locale);
  const numberOfMonths = Math.min(12, Math.max(1, Math.floor(Number(opts.numberOfMonths) || 1)));
  const captionLayout: CalendarCaptionLayout =
    numberOfMonths > 1 ? 'label' : opts.captionLayout === 'label' ? 'label' : 'dropdown';
  const timeZone =
    opts.timeZone != null && String(opts.timeZone).trim() !== ''
      ? String(opts.timeZone).trim()
      : null;
  const extraDisabledSet = parseCalendarIsoList(opts.disabled);
  const modifierGroupsMap = parseCalendarModifierGroups(opts.modifiers);
  const modifierClassByKey = parseModifiersClassNames(opts.modifiersClassNames);

  const initialMonth = resolveInitialCalendarVisibleMonth({
    visibleMonth: opts.visibleMonth,
    selected: opts.selected,
  });
  const initialSelected = opts.selected ? parseISO(opts.selected) : null;

  const themeClasses: CalendarThemeClasses = {
    dayTd: '',
    rangeStart: '',
    rangeMiddle: '',
    rangeEnd: '',
    today: '',
    outside: '',
    disabled: '',
    ...opts.themeClasses,
  };

  return {
    mode,
    weekStartsOn,
    showOutsideDays,
    numberOfMonths,
    captionLayout,
    timeZone,
    localeId,
    dfLocale: enUS,
    weekdayLabels: buildWeekdayLabels(weekStartsOn, enUS),
    visibleMonth: initialMonth,
    selectedSingle: mode === 'single' ? initialSelected : null,
    rangeFrom: mode === 'range' ? initialSelected : null,
    rangeTo: null,
    weeksByMonth: [] as CalendarCell[][][],
    weeks: [] as CalendarCell[][],
    monthLabel: '',
    resolvedTodayIso: format(new Date(), 'yyyy-MM-dd'),
    modifierClassByKey,
    themeClasses,
    focusedIso: null as string | null,

    init() {
      this.refresh();
      this.reconcileFocus();
      if (this.localeId !== CALENDAR_DEFAULT_LOCALE_ID) {
        void loadCalendarLocale(this.localeId).then((loc) => {
          this.dfLocale = loc;
          this.refresh();
          this.reconcileFocus();
        });
      }
    },

    refresh() {
      const todayIsoResolved = getTodayIsoInTimeZone(timeZone);
      this.resolvedTodayIso = todayIsoResolved ?? format(new Date(), 'yyyy-MM-dd');
      const fmtMonth = (d: Date) => format(d, 'MMMM yyyy', { locale: this.dfLocale });
      if (this.numberOfMonths <= 1) {
        this.monthLabel = fmtMonth(this.visibleMonth);
      } else {
        const last = addMonths(this.visibleMonth, this.numberOfMonths - 1);
        this.monthLabel = `${fmtMonth(this.visibleMonth)} – ${fmtMonth(last)}`;
      }
      this.weekdayLabels = buildWeekdayLabels(this.weekStartsOn, this.dfLocale);
      const weekOpts = {
        weekStartsOn: this.weekStartsOn,
        showOutsideDays: this.showOutsideDays,
        min: minDate,
        max: maxDate,
        selectedSingle: this.selectedSingle,
        rangeFrom: this.rangeFrom,
        rangeTo: this.rangeTo,
        mode: this.mode,
        extraDisabledIsos: extraDisabledSet,
        todayIso: todayIsoResolved,
        modifierGroups: modifierGroupsMap,
      };
      const wbm: CalendarCell[][][] = [];
      for (let i = 0; i < this.numberOfMonths; i++) {
        wbm.push(buildCalendarWeeks(addMonths(this.visibleMonth, i), weekOpts));
      }
      this.weeksByMonth = wbm;
      this.weeks = wbm.flatMap((wm) => wm);
    },

    reconcileFocus(opts?: { preferDayOfMonth?: number }) {
      if (!this.weeks.length) {
        return;
      }
      if (opts?.preferDayOfMonth != null) {
        const iso = pickIsoForDayOfMonthInMonth(this.weeks, opts.preferDayOfMonth);
        if (iso) {
          this.focusedIso = iso;
          return;
        }
      }
      if (this.focusedIso) {
        const flat = flattenCalendarWeeks(this.weeks);
        const ok = flat.some((c) => c.iso === this.focusedIso && !c.disabled);
        if (ok) {
          return;
        }
      }
      const selectedIso =
        this.mode === 'single' && this.selectedSingle
          ? format(this.selectedSingle, 'yyyy-MM-dd')
          : null;
      const rangeFromIso =
        this.mode === 'range' && this.rangeFrom ? format(this.rangeFrom, 'yyyy-MM-dd') : null;
      this.focusedIso = pickInitialCalendarFocusIso(this.weeks, {
        mode: this.mode,
        selectedIso,
        rangeFromIso,
        todayIso: this.resolvedTodayIso,
      });
    },

    canPrev() {
      if (!minDate) {
        return true;
      }
      return monthsSpanCanDisplay(
        subMonths(this.visibleMonth, 1),
        this.numberOfMonths,
        minDate,
        maxDate
      );
    },

    canNext() {
      if (!maxDate) {
        return true;
      }
      return monthsSpanCanDisplay(
        addMonths(this.visibleMonth, 1),
        this.numberOfMonths,
        minDate,
        maxDate
      );
    },

    navigateToVisibleMonth(nextMonthStart: Date) {
      const next = startOfMonth(nextMonthStart);
      if (!monthCanDisplayCalendarView(next, minDate, maxDate)) {
        return;
      }
      const self = this as Partial<CalendarComponentThis>;
      const restoreFocus = activeDayButtonInCalendarRoot(self.$el ?? null);
      const dom = this.focusedIso ? parseISO(this.focusedIso).getDate() : null;
      this.visibleMonth = next;
      this.refresh();
      this.reconcileFocus({ preferDayOfMonth: dom ?? undefined });
      if (restoreFocus && this.focusedIso && typeof self.$nextTick === 'function') {
        self.$nextTick(() => this.focusDayButton(this.focusedIso!));
      }
    },

    prevMonth() {
      if (!this.canPrev()) {
        return;
      }
      this.navigateToVisibleMonth(subMonths(this.visibleMonth, 1));
    },

    nextMonth() {
      if (!this.canNext()) {
        return;
      }
      this.navigateToVisibleMonth(addMonths(this.visibleMonth, 1));
    },

    captionMonth() {
      return this.visibleMonth.getMonth() + 1;
    },

    captionYear() {
      return this.visibleMonth.getFullYear();
    },

    isCaptionMonthDisabled(month1to12: number) {
      return isCalendarCaptionMonthDisabled(
        this.visibleMonth.getFullYear(),
        month1to12,
        minDate,
        maxDate
      );
    },

    onCaptionMonthChange(event: Event) {
      const raw = (event.target as { value?: string } | null)?.value;
      if (raw === undefined || raw === '') {
        return;
      }
      const m = Number.parseInt(raw, 10);
      if (Number.isNaN(m)) {
        return;
      }
      const y = this.visibleMonth.getFullYear();
      this.navigateToVisibleMonth(new Date(y, m - 1, 1));
    },

    onCaptionYearChange(event: Event) {
      const raw = (event.target as { value?: string } | null)?.value;
      if (raw === undefined || raw === '') {
        return;
      }
      const y = Number.parseInt(raw, 10);
      if (Number.isNaN(y)) {
        return;
      }
      const m = this.visibleMonth.getMonth() + 1;
      this.navigateToVisibleMonth(new Date(y, m - 1, 1));
    },

    panelMonthLabel(monthIndex: number) {
      const d = addMonths(this.visibleMonth, monthIndex);
      return format(d, 'MMMM yyyy', { locale: this.dfLocale });
    },

    panelGridLabel(monthIndex: number) {
      return this.panelMonthLabel(monthIndex);
    },

    cellSelected(cell: CalendarCell): boolean {
      return !!(cell.selectedSingle || cell.rangeStart || cell.rangeMiddle || cell.rangeEnd);
    },

    tdClass(cell: CalendarCell): string {
      const t = this.themeClasses;
      if (!t.dayTd) {
        return '';
      }
      const parts = [t.dayTd];
      if (cell.disabled && t.disabled) {
        parts.push(t.disabled);
      } else if (cell.outside && t.outside) {
        parts.push(t.outside);
      }
      if (cell.today && t.today) {
        parts.push(t.today);
      }
      if (cell.rangeStart && t.rangeStart) {
        parts.push(t.rangeStart);
      }
      if (cell.rangeMiddle && t.rangeMiddle) {
        parts.push(t.rangeMiddle);
      }
      if (cell.rangeEnd && t.rangeEnd) {
        parts.push(t.rangeEnd);
      }
      for (const key of cell.modifierKeys) {
        const modCls = this.modifierClassByKey[key];
        if (modCls) {
          parts.push(modCls);
        }
      }
      return parts.join(' ');
    },

    dayAriaLabel(iso: string): string {
      return format(parseISO(iso), 'MMMM d, yyyy', { locale: this.dfLocale });
    },

    dayTabindex(cell: CalendarCell): 0 | -1 {
      if (cell.disabled) {
        return -1;
      }
      if (!this.focusedIso) {
        return -1;
      }
      return cell.iso === this.focusedIso ? 0 : -1;
    },

    onGridFocusin(event: FocusEvent) {
      const t = event.target;
      if (t instanceof HTMLButtonElement && t.hasAttribute('data-day')) {
        const iso = t.getAttribute('data-day');
        if (iso) {
          this.focusedIso = iso;
          const d = parseISO(iso);
          const inSpan = isDateInVisibleMonthSpan(d, this.visibleMonth, this.numberOfMonths);
          if (this.numberOfMonths <= 1) {
            if (
              !isSameMonth(d, this.visibleMonth) &&
              monthCanDisplayCalendarView(startOfMonth(d), minDate, maxDate)
            ) {
              this.visibleMonth = startOfMonth(d);
              this.refresh();
              const self = this as Partial<CalendarComponentThis>;
              if (typeof self.$nextTick === 'function') {
                self.$nextTick(() => this.focusDayButton(iso));
              }
            }
          } else if (!inSpan && monthCanDisplayCalendarView(startOfMonth(d), minDate, maxDate)) {
            this.visibleMonth = startOfMonth(d);
            this.refresh();
            const self = this as Partial<CalendarComponentThis>;
            if (typeof self.$nextTick === 'function') {
              self.$nextTick(() => this.focusDayButton(iso));
            }
          }
        }
      }
    },

    focusDayButton(iso: string) {
      const self = this as Partial<CalendarComponentThis>;
      const root = self.$el;
      if (!root || !iso) {
        return;
      }
      const btn = root.querySelector<HTMLButtonElement>(`button[data-day="${iso}"]`);
      btn?.focus({ preventScroll: true });
    },

    onGridKeydown(event: KeyboardEvent) {
      const navKeys = [
        'ArrowLeft',
        'ArrowRight',
        'ArrowUp',
        'ArrowDown',
        'Home',
        'End',
        'PageUp',
        'PageDown',
      ];
      if (!navKeys.includes(event.key)) {
        return;
      }

      const self = this as Partial<CalendarComponentThis>;
      if (!this.focusedIso) {
        this.reconcileFocus();
      }
      if (!this.focusedIso) {
        return;
      }

      if (
        event.key === 'ArrowLeft' ||
        event.key === 'ArrowRight' ||
        event.key === 'ArrowUp' ||
        event.key === 'ArrowDown' ||
        event.key === 'Home' ||
        event.key === 'End'
      ) {
        const next = moveCalendarKeyboardFocus(this.weeks, this.focusedIso, event.key);
        if (next && next !== this.focusedIso) {
          event.preventDefault();
          const nextDate = parseISO(next);
          const inSpan = isDateInVisibleMonthSpan(nextDate, this.visibleMonth, this.numberOfMonths);
          const shouldReanchor =
            this.numberOfMonths <= 1 ? !isSameMonth(nextDate, this.visibleMonth) : !inSpan;
          if (
            shouldReanchor &&
            monthCanDisplayCalendarView(startOfMonth(nextDate), minDate, maxDate)
          ) {
            this.visibleMonth = startOfMonth(nextDate);
            this.refresh();
          }
          this.focusedIso = next;
          if (typeof self.$nextTick === 'function') {
            self.$nextTick(() => this.focusDayButton(next));
          }
          return;
        }

        // No in-grid target (e.g. `showOutsideDays: false` / last week ends inside the month).
        // Same as Page Up/Down: move month and keep day-of-month when possible.
        if (next === null) {
          const dom = parseISO(this.focusedIso).getDate();
          if ((event.key === 'ArrowRight' || event.key === 'ArrowDown') && this.canNext()) {
            event.preventDefault();
            this.visibleMonth = addMonths(this.visibleMonth, 1);
            this.refresh();
            this.reconcileFocus({ preferDayOfMonth: dom });
            if (typeof self.$nextTick === 'function') {
              self.$nextTick(() => this.focusedIso && this.focusDayButton(this.focusedIso));
            }
            return;
          }
          if ((event.key === 'ArrowLeft' || event.key === 'ArrowUp') && this.canPrev()) {
            event.preventDefault();
            this.visibleMonth = subMonths(this.visibleMonth, 1);
            this.refresh();
            this.reconcileFocus({ preferDayOfMonth: dom });
            if (typeof self.$nextTick === 'function') {
              self.$nextTick(() => this.focusedIso && this.focusDayButton(this.focusedIso));
            }
            return;
          }
        }
        return;
      }

      if (event.key === 'PageUp' && this.canPrev()) {
        event.preventDefault();
        const dom = parseISO(this.focusedIso).getDate();
        this.visibleMonth = subMonths(this.visibleMonth, 1);
        this.refresh();
        this.reconcileFocus({ preferDayOfMonth: dom });
        if (typeof self.$nextTick === 'function') {
          self.$nextTick(() => this.focusedIso && this.focusDayButton(this.focusedIso));
        }
        return;
      }

      if (event.key === 'PageDown' && this.canNext()) {
        event.preventDefault();
        const dom = parseISO(this.focusedIso).getDate();
        this.visibleMonth = addMonths(this.visibleMonth, 1);
        this.refresh();
        this.reconcileFocus({ preferDayOfMonth: dom });
        if (typeof self.$nextTick === 'function') {
          self.$nextTick(() => this.focusedIso && this.focusDayButton(this.focusedIso));
        }
      }
    },

    selectCell(cell: CalendarCell) {
      if (cell.disabled) {
        return;
      }
      this.focusedIso = cell.iso;
      const d = parseISO(cell.iso);
      const inSpan = isDateInVisibleMonthSpan(d, this.visibleMonth, this.numberOfMonths);
      if (this.numberOfMonths <= 1) {
        if (
          !isSameMonth(d, this.visibleMonth) &&
          monthCanDisplayCalendarView(startOfMonth(d), minDate, maxDate)
        ) {
          this.visibleMonth = startOfMonth(d);
        }
      } else if (!inSpan && monthCanDisplayCalendarView(startOfMonth(d), minDate, maxDate)) {
        this.visibleMonth = startOfMonth(d);
      }
      if (this.mode === 'single') {
        this.selectedSingle = d;
        (
          this as unknown as { $dispatch: (n: string, d?: Record<string, string>) => void }
        ).$dispatch('calendar-select', {
          iso: cell.iso,
        });
      } else {
        if (!this.rangeFrom || (this.rangeFrom && this.rangeTo)) {
          this.rangeFrom = d;
          this.rangeTo = null;
        } else {
          this.rangeTo = d;
          if (this.rangeFrom && this.rangeTo) {
            const a = this.rangeFrom.getTime();
            const b = this.rangeTo.getTime();
            if (a > b) {
              const t = this.rangeFrom;
              this.rangeFrom = this.rangeTo;
              this.rangeTo = t;
            }
          }
        }
        const fromIso = this.rangeFrom ? format(this.rangeFrom, 'yyyy-MM-dd') : null;
        const toIso = this.rangeTo ? format(this.rangeTo, 'yyyy-MM-dd') : null;
        (
          this as unknown as {
            $dispatch: (n: string, d?: Record<string, string | null>) => void;
          }
        ).$dispatch('calendar-select-range', { from: fromIso, to: toIso });
      }
      this.refresh();
      this.reconcileFocus();
    },
  };
}
