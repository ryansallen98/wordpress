import { describe, expect, it } from 'vitest';
import { enUS } from 'date-fns/locale/en-US';

import { buildCalendarWeeks, buildWeekdayLabels } from './calendar_grid';

describe('buildWeekdayLabels', () => {
  it('returns seven labels starting Sunday', () => {
    const labels = buildWeekdayLabels(0, enUS);
    expect(labels).toHaveLength(7);
    expect(labels[0]).toBe('Su');
    expect(labels[6]).toBe('Sa');
  });

  it('returns seven labels starting Monday', () => {
    const labels = buildWeekdayLabels(1, enUS);
    expect(labels).toHaveLength(7);
    expect(labels[0]).toBe('Mo');
  });
});

describe('buildCalendarWeeks', () => {
  const april2026 = new Date(2026, 3, 1);

  it('includes outside days when showOutsideDays is true (April 2026, Sunday week start)', () => {
    const weeks = buildCalendarWeeks(april2026, {
      weekStartsOn: 0,
      showOutsideDays: true,
      mode: 'single',
    });
    const w0 = weeks[0];
    expect(w0).toBeDefined();
    expect(w0![0]!.iso).toBe('2026-03-29');
    expect(w0![0]!.outside).toBe(true);
    expect(w0![3]!.iso).toBe('2026-04-01');
    expect(w0![3]!.outside).toBe(false);
  });

  it('uses padding placeholders when showOutsideDays is false (7 columns, weekday alignment)', () => {
    const weeks = buildCalendarWeeks(april2026, {
      weekStartsOn: 0,
      showOutsideDays: false,
      mode: 'single',
    });
    expect(weeks.every((w) => w.length === 7)).toBe(true);
    const w0 = weeks[0];
    expect(w0).toBeDefined();
    expect(w0![0]!.padding).toBe(true);
    expect(w0![1]!.padding).toBe(true);
    expect(w0![2]!.padding).toBe(true);
    expect(w0![3]!.iso).toBe('2026-04-01');
    expect(w0![3]!.outside).toBe(false);
    expect(w0![3]!.padding).toBeFalsy();
  });

  it('marks selected single day', () => {
    const selected = new Date(2026, 3, 15);
    const weeks = buildCalendarWeeks(april2026, {
      weekStartsOn: 0,
      showOutsideDays: true,
      mode: 'single',
      selectedSingle: selected,
    });
    const flat = weeks.flat();
    const hit = flat.find((c) => c.iso === '2026-04-15');
    expect(hit?.selectedSingle).toBe(true);
    expect(hit?.modifierKeys).toEqual([]);
  });

  it('disables extra ISO dates and attaches modifier keys', () => {
    const weeks = buildCalendarWeeks(april2026, {
      weekStartsOn: 0,
      showOutsideDays: true,
      mode: 'single',
      extraDisabledIsos: new Set(['2026-04-10']),
      modifierGroups: { booked: new Set(['2026-04-10', '2026-04-11']) },
    });
    const flat = weeks.flat();
    expect(flat.find((c) => c.iso === '2026-04-10')?.disabled).toBe(true);
    expect(flat.find((c) => c.iso === '2026-04-10')?.modifierKeys).toContain('booked');
    expect(flat.find((c) => c.iso === '2026-04-11')?.disabled).toBe(false);
    expect(flat.find((c) => c.iso === '2026-04-11')?.modifierKeys).toContain('booked');
  });

  it('uses todayIso override', () => {
    const weeks = buildCalendarWeeks(april2026, {
      weekStartsOn: 0,
      showOutsideDays: true,
      mode: 'single',
      todayIso: '2026-04-15',
    });
    const flat = weeks.flat();
    expect(flat.find((c) => c.iso === '2026-04-15')?.today).toBe(true);
    expect(flat.find((c) => c.iso === '2026-04-08')?.today).toBe(false);
  });

  it('disables days before min', () => {
    const weeks = buildCalendarWeeks(april2026, {
      weekStartsOn: 0,
      showOutsideDays: true,
      mode: 'single',
      min: new Date(2026, 3, 10),
    });
    const flat = weeks.flat();
    expect(flat.find((c) => c.iso === '2026-04-09')?.disabled).toBe(true);
    expect(flat.find((c) => c.iso === '2026-04-10')?.disabled).toBe(false);
  });

  it('marks range middle between from and to', () => {
    const weeks = buildCalendarWeeks(april2026, {
      weekStartsOn: 0,
      showOutsideDays: true,
      mode: 'range',
      rangeFrom: new Date(2026, 3, 10),
      rangeTo: new Date(2026, 3, 12),
    });
    const flat = weeks.flat();
    expect(flat.find((c) => c.iso === '2026-04-10')?.rangeStart).toBe(true);
    expect(flat.find((c) => c.iso === '2026-04-11')?.rangeMiddle).toBe(true);
    expect(flat.find((c) => c.iso === '2026-04-12')?.rangeEnd).toBe(true);
  });

  it('normalizes inverted range from/to', () => {
    const weeks = buildCalendarWeeks(april2026, {
      weekStartsOn: 0,
      showOutsideDays: true,
      mode: 'range',
      rangeFrom: new Date(2026, 3, 12),
      rangeTo: new Date(2026, 3, 10),
    });
    const flat = weeks.flat();
    expect(flat.find((c) => c.iso === '2026-04-10')?.rangeStart).toBe(true);
    expect(flat.find((c) => c.iso === '2026-04-12')?.rangeEnd).toBe(true);
  });
});
