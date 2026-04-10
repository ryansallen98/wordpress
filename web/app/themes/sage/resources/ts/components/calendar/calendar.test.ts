import { describe, expect, it, vi } from 'vitest';
import { parseISO, startOfMonth } from 'date-fns';

import {
  buildCalendarYearOptions,
  calendar,
  isCalendarCaptionMonthDisabled,
  monthsSpanCanDisplay,
  monthCanDisplayCalendarView,
  moveCalendarKeyboardFocus,
  pickInitialCalendarFocusIso,
  resolveInitialCalendarVisibleMonth,
} from './calendar';
import { buildCalendarWeeks } from './calendar_grid';

const emptyTheme = {
  dayTd: 'td',
  rangeStart: '',
  rangeMiddle: '',
  rangeEnd: '',
  today: '',
  outside: '',
  disabled: '',
};

describe('calendar Alpine factory', () => {
  it('initializes single mode and refreshes weeks', () => {
    const c = calendar({
      mode: 'single',
      visibleMonth: '2026-04-01',
      selected: '2026-04-15',
      themeClasses: emptyTheme,
    });
    c.init();
    expect(c.weeks.length).toBeGreaterThan(0);
    expect(c.selectedSingle).not.toBeNull();
    expect(c.monthLabel).toContain('2026');
  });

  it('prevMonth does not run when canPrev is false', () => {
    const c = calendar({
      visibleMonth: '2026-04-01',
      min: '2026-04-10',
      themeClasses: emptyTheme,
    });
    c.init();
    const before = c.visibleMonth.getTime();
    c.prevMonth();
    expect(c.visibleMonth.getTime()).toBe(before);
  });

  it('nextMonth advances when allowed', () => {
    const c = calendar({
      visibleMonth: '2026-04-01',
      themeClasses: emptyTheme,
    });
    c.init();
    c.nextMonth();
    expect(c.visibleMonth.getMonth()).toBe(4);
  });

  it('caption month select navigates to chosen month', () => {
    const c = calendar({
      visibleMonth: '2026-04-01',
      themeClasses: emptyTheme,
    });
    c.init();
    c.onCaptionMonthChange({
      target: { value: '8' },
    } as unknown as Event);
    expect(c.visibleMonth.getMonth()).toBe(7);
    expect(c.visibleMonth.getFullYear()).toBe(2026);
  });

  it('caption year select navigates to chosen year', () => {
    const c = calendar({
      visibleMonth: '2026-04-01',
      themeClasses: emptyTheme,
    });
    c.init();
    c.onCaptionYearChange({
      target: { value: '2028' },
    } as unknown as Event);
    expect(c.visibleMonth.getFullYear()).toBe(2028);
    expect(c.visibleMonth.getMonth()).toBe(3);
  });

  it('sets focusedIso after init for roving tabindex', () => {
    const c = calendar({
      mode: 'single',
      visibleMonth: '2026-04-01',
      selected: '2026-04-15',
      themeClasses: emptyTheme,
    });
    c.init();
    expect(c.focusedIso).toBe('2026-04-15');
  });

  it('opens the month of selected when visibleMonth is omitted', () => {
    const c = calendar({
      mode: 'single',
      selected: '2026-08-15',
      themeClasses: emptyTheme,
    });
    c.init();
    expect(c.visibleMonth.getMonth()).toBe(7);
    expect(c.visibleMonth.getFullYear()).toBe(2026);
    expect(c.captionMonth()).toBe(8);
    expect(c.captionYear()).toBe(2026);
    expect(c.focusedIso).toBe('2026-08-15');
  });

  it('defaults to en-US when locale omitted', () => {
    const c = calendar({
      visibleMonth: '2026-04-01',
      themeClasses: emptyTheme,
    });
    c.init();
    expect(c.localeId).toBe('en-US');
    expect(c.dfLocale.code).toBe('en-US');
  });

  it('builds two months when numberOfMonths is 2', () => {
    const c = calendar({
      visibleMonth: '2026-04-01',
      numberOfMonths: 2,
      themeClasses: emptyTheme,
    });
    c.init();
    expect(c.weeksByMonth).toHaveLength(2);
    expect(c.weeks.length).toBeGreaterThan(0);
  });

  it('forces label caption when numberOfMonths is greater than 1 even if dropdown requested', () => {
    const c = calendar({
      visibleMonth: '2026-04-01',
      numberOfMonths: 2,
      captionLayout: 'dropdown',
      themeClasses: emptyTheme,
    });
    c.init();
    expect(c.captionLayout).toBe('label');
  });

  it('applies disabled and modifier class map', () => {
    const c = calendar({
      visibleMonth: '2026-04-01',
      themeClasses: { ...emptyTheme, dayTd: 'td' },
      disabled: ['2026-04-10'],
      modifiers: { booked: ['2026-04-11'] },
      modifiersClassNames: { booked: 'booked-mod' },
    });
    c.init();
    const flat = c.weeks.flat();
    const d10 = flat.find((x) => x.iso === '2026-04-10');
    const d11 = flat.find((x) => x.iso === '2026-04-11');
    expect(d10?.disabled).toBe(true);
    expect(d11?.modifierKeys).toContain('booked');
    expect(c.tdClass(d11!)).toContain('booked-mod');
  });

  it('loads fr locale asynchronously and updates month label', async () => {
    const c = calendar({
      locale: 'fr',
      visibleMonth: '2026-04-01',
      themeClasses: emptyTheme,
    });
    c.init();
    expect(c.localeId).toBe('fr');
    await vi.waitFor(
      () => {
        expect(c.dfLocale.code).toBe('fr');
      },
      { timeout: 5000 }
    );
    expect(c.monthLabel.toLowerCase()).toContain('avril');
  });
});

describe('calendar keyboard helpers', () => {
  const april2026 = buildCalendarWeeks(new Date(2026, 3, 1), {
    weekStartsOn: 0,
    showOutsideDays: true,
    min: null,
    max: null,
    selectedSingle: new Date(2026, 3, 15),
    rangeFrom: null,
    rangeTo: null,
    mode: 'single',
  });

  it('moves focus right and skips disabled', () => {
    const weeks = buildCalendarWeeks(new Date(2026, 3, 1), {
      weekStartsOn: 0,
      showOutsideDays: true,
      min: new Date(2026, 3, 10),
      max: null,
      selectedSingle: null,
      rangeFrom: null,
      rangeTo: null,
      mode: 'single',
    });
    expect(moveCalendarKeyboardFocus(weeks, '2026-04-09', 'ArrowRight')).toBe('2026-04-10');
  });

  it('moves focus vertically within the grid', () => {
    const down = moveCalendarKeyboardFocus(april2026, '2026-04-08', 'ArrowDown');
    expect(down).toBe('2026-04-15');
    const up = moveCalendarKeyboardFocus(april2026, '2026-04-15', 'ArrowUp');
    expect(up).toBe('2026-04-08');
  });

  it('returns null past the last in-grid day when outside days are hidden (arrow month-wrap target)', () => {
    const oct2026InMonthOnly = buildCalendarWeeks(new Date(2026, 9, 1), {
      weekStartsOn: 0,
      showOutsideDays: false,
      min: null,
      max: null,
      selectedSingle: null,
      rangeFrom: null,
      rangeTo: null,
      mode: 'single',
    });
    const flat = oct2026InMonthOnly.flat();
    const lastIso = flat[flat.length - 1]!.iso;
    expect(lastIso).toBe('2026-10-31');
    expect(moveCalendarKeyboardFocus(oct2026InMonthOnly, lastIso, 'ArrowRight')).toBeNull();
    expect(moveCalendarKeyboardFocus(oct2026InMonthOnly, lastIso, 'ArrowDown')).toBeNull();
    const firstIso = flat[0]!.iso;
    expect(firstIso).toBe('2026-10-01');
    expect(moveCalendarKeyboardFocus(oct2026InMonthOnly, firstIso, 'ArrowLeft')).toBeNull();
    expect(moveCalendarKeyboardFocus(oct2026InMonthOnly, firstIso, 'ArrowUp')).toBeNull();
  });

  it('Home and End move within the week row', () => {
    const home = moveCalendarKeyboardFocus(april2026, '2026-04-16', 'Home');
    expect(home).toBe('2026-04-12');
    const end = moveCalendarKeyboardFocus(april2026, '2026-04-16', 'End');
    expect(end).toBe('2026-04-18');
  });

  it('pickInitialCalendarFocusIso prefers selection then today then first enabled', () => {
    const iso = pickInitialCalendarFocusIso(april2026, {
      mode: 'single',
      selectedIso: '2026-04-22',
      rangeFromIso: null,
    });
    expect(iso).toBe('2026-04-22');
  });
});

describe('resolveInitialCalendarVisibleMonth', () => {
  it('prefers selected over visibleMonth when both set (grid + caption stay aligned)', () => {
    const d = resolveInitialCalendarVisibleMonth({
      visibleMonth: '2026-01-01',
      selected: '2026-08-15',
    });
    expect(d.getMonth()).toBe(7);
  });

  it('uses visibleMonth when selected is absent', () => {
    const d = resolveInitialCalendarVisibleMonth({
      visibleMonth: '2026-01-01',
      selected: undefined,
    });
    expect(d.getMonth()).toBe(0);
  });

  it('uses today when neither is set', () => {
    const d = resolveInitialCalendarVisibleMonth({
      visibleMonth: undefined,
      selected: undefined,
    });
    const now = new Date();
    expect(d.getFullYear()).toBe(now.getFullYear());
    expect(d.getMonth()).toBe(now.getMonth());
    expect(d.getDate()).toBe(1);
  });
});

describe('buildCalendarYearOptions', () => {
  it('uses min and max years when both are set', () => {
    expect(buildCalendarYearOptions(2026, parseISO('2026-04-10'), parseISO('2028-06-01'))).toEqual([
      2026, 2027, 2028,
    ]);
  });

  it('extends unbounded range to include visible year', () => {
    expect(buildCalendarYearOptions(1995, null, null, 2)).toEqual([1993, 1994, 1995, 1996, 1997]);
  });
});

describe('isCalendarCaptionMonthDisabled', () => {
  it('disables months with no overlap with min/max window', () => {
    const min = parseISO('2026-04-15');
    const max = parseISO('2026-06-20');
    expect(isCalendarCaptionMonthDisabled(2026, 3, min, max)).toBe(true);
    expect(isCalendarCaptionMonthDisabled(2026, 4, min, max)).toBe(false);
    expect(isCalendarCaptionMonthDisabled(2026, 7, min, max)).toBe(true);
  });
});

describe('monthsSpanCanDisplay', () => {
  it('requires every month in the span to overlap min/max', () => {
    const min = parseISO('2026-04-15');
    const max = parseISO('2026-06-20');
    expect(monthsSpanCanDisplay(parseISO('2026-04-01'), 2, min, max)).toBe(true);
    expect(monthsSpanCanDisplay(parseISO('2026-03-01'), 2, min, max)).toBe(false);
  });
});

describe('monthCanDisplayCalendarView', () => {
  it('rejects months entirely before min or after max', () => {
    const min = parseISO('2026-04-15');
    const max = parseISO('2026-06-20');
    expect(monthCanDisplayCalendarView(startOfMonth(parseISO('2026-03-01')), min, max)).toBe(false);
    expect(monthCanDisplayCalendarView(startOfMonth(parseISO('2026-04-01')), min, max)).toBe(true);
    expect(monthCanDisplayCalendarView(startOfMonth(parseISO('2026-07-01')), min, max)).toBe(false);
  });

  it('allows any month when min and max are null', () => {
    expect(monthCanDisplayCalendarView(startOfMonth(parseISO('2030-01-01')), null, null)).toBe(
      true
    );
  });
});
