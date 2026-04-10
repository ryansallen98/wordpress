import {
  addDays,
  eachDayOfInterval,
  endOfMonth,
  endOfWeek,
  format,
  isAfter,
  isBefore,
  isSameDay,
  isSameMonth,
  isToday,
  parseISO,
  startOfMonth,
  startOfWeek,
  type Locale,
} from 'date-fns';

export type CalendarMode = 'single' | 'range';

export interface CalendarCell {
  /** True for empty slots when `showOutsideDays` is false (keeps 7 columns + weekday alignment). */
  padding?: boolean;
  iso: string;
  label: string;
  outside: boolean;
  today: boolean;
  disabled: boolean;
  /** Modifier names from `modifiers` prop whose date sets include this ISO day. */
  modifierKeys: string[];
  selectedSingle: boolean;
  rangeStart: boolean;
  rangeMiddle: boolean;
  rangeEnd: boolean;
}

export interface BuildCalendarWeeksOptions {
  weekStartsOn: 0 | 1;
  showOutsideDays: boolean;
  min?: Date | null;
  max?: Date | null;
  selectedSingle?: Date | null;
  rangeFrom?: Date | null;
  rangeTo?: Date | null;
  mode: CalendarMode;
  /** Extra disabled calendar days (ISO `yyyy-MM-dd`), merged with min/max. */
  extraDisabledIsos?: Set<string> | null;
  /** When set, `today` matches this ISO instead of `isToday()` (timezone-aware). */
  todayIso?: string | null;
  /** Named sets of ISO dates → `modifierKeys` on each cell (styling only unless also in `extraDisabledIsos`). */
  modifierGroups?: Record<string, Set<string>> | null;
}

/** Weekday header labels (e.g. Su, Mo) for the given week start and locale. */
export function buildWeekdayLabels(weekStartsOn: 0 | 1, locale: Locale): string[] {
  const refSunday = new Date(2024, 0, 7);
  const start = startOfWeek(refSunday, { weekStartsOn });
  return Array.from({ length: 7 }, (_, i) =>
    format(addDays(start, i), 'EEE', { locale }).slice(0, 2)
  );
}

function normalizeRange(
  from: Date | null | undefined,
  to: Date | null | undefined
): [Date | null, Date | null] {
  if (!from || !to) {
    return [from ?? null, to ?? null];
  }
  if (isAfter(from, to)) {
    return [to, from];
  }
  return [from, to];
}

/** Build calendar rows (weeks) for the month containing `visibleMonth`. */
export function buildCalendarWeeks(
  visibleMonth: Date,
  options: BuildCalendarWeeksOptions
): CalendarCell[][] {
  const monthStart = startOfMonth(visibleMonth);
  const monthEnd = endOfMonth(visibleMonth);
  const gridStart = startOfWeek(monthStart, { weekStartsOn: options.weekStartsOn });
  const gridEnd = endOfWeek(monthEnd, { weekStartsOn: options.weekStartsOn });

  const days = eachDayOfInterval({ start: gridStart, end: gridEnd });
  const [rangeFrom, rangeTo] = normalizeRange(options.rangeFrom, options.rangeTo);

  const extraDisabled = options.extraDisabledIsos ?? null;
  const modGroups = options.modifierGroups ?? null;
  const todayIso = options.todayIso ?? null;

  const cells: CalendarCell[] = days.map((d) => {
    const iso = format(d, 'yyyy-MM-dd');
    const outside = !isSameMonth(d, monthStart);

    if (outside && !options.showOutsideDays) {
      return {
        iso: `__pad__${iso}`,
        padding: true,
        label: '',
        outside: false,
        today: false,
        disabled: true,
        modifierKeys: [],
        selectedSingle: false,
        rangeStart: false,
        rangeMiddle: false,
        rangeEnd: false,
      };
    }

    let disabled = false;
    if (options.min && isBefore(d, options.min)) {
      disabled = true;
    }
    if (options.max && isAfter(d, options.max)) {
      disabled = true;
    }
    if (extraDisabled?.has(iso)) {
      disabled = true;
    }

    const modifierKeys: string[] = [];
    if (modGroups) {
      for (const [name, set] of Object.entries(modGroups)) {
        if (set.has(iso)) {
          modifierKeys.push(name);
        }
      }
    }

    let selectedSingle = false;
    let rangeStart = false;
    let rangeMiddle = false;
    let rangeEnd = false;

    if (options.mode === 'single' && options.selectedSingle) {
      selectedSingle = isSameDay(d, options.selectedSingle);
    }

    if (options.mode === 'range' && rangeFrom) {
      if (rangeTo) {
        rangeStart = isSameDay(d, rangeFrom);
        rangeEnd = isSameDay(d, rangeTo);
        const gteFrom = !isBefore(d, rangeFrom);
        const lteTo = !isAfter(d, rangeTo);
        rangeMiddle = !rangeStart && !rangeEnd && gteFrom && lteTo;
      } else {
        rangeStart = isSameDay(d, rangeFrom);
      }
    }

    return {
      iso,
      label: format(d, 'd'),
      outside,
      today: todayIso != null ? iso === todayIso : isToday(d),
      disabled,
      modifierKeys,
      selectedSingle,
      rangeStart,
      rangeMiddle,
      rangeEnd,
    };
  });

  const weeks: CalendarCell[][] = [];
  for (let i = 0; i < cells.length; i += 7) {
    weeks.push(cells.slice(i, i + 7));
  }
  return weeks;
}

export function parseIsoToStartOfMonth(iso: string): Date {
  return startOfMonth(parseISO(iso));
}
