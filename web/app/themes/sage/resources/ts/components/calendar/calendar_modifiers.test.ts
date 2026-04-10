import { describe, expect, it } from 'vitest';

import {
  parseCalendarIsoList,
  parseCalendarModifierGroups,
  parseModifiersClassNames,
} from './calendar_modifiers';

describe('parseCalendarIsoList', () => {
  it('collects valid ISO dates', () => {
    const s = parseCalendarIsoList(['2026-04-10', 'bad', '2026-04-11']);
    expect(s.has('2026-04-10')).toBe(true);
    expect(s.has('2026-04-11')).toBe(true);
    expect(s.size).toBe(2);
  });

  it('returns empty for non-array', () => {
    expect(parseCalendarIsoList(null).size).toBe(0);
  });
});

describe('parseCalendarModifierGroups', () => {
  it('builds named sets', () => {
    const g = parseCalendarModifierGroups({
      booked: ['2026-04-05'],
      other: ['2026-04-06'],
    });
    expect(g.booked?.has('2026-04-05')).toBe(true);
    expect(g.other?.has('2026-04-06')).toBe(true);
  });
});

describe('parseModifiersClassNames', () => {
  it('keeps string class maps', () => {
    const m = parseModifiersClassNames({
      booked: '[&>button]:line-through',
    });
    expect(m.booked).toBe('[&>button]:line-through');
  });
});
