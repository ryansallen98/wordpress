import { describe, expect, it } from 'vitest';

import { getTodayIsoInTimeZone } from './calendar_timezone';

describe('getTodayIsoInTimeZone', () => {
  it('returns null for empty zone (use local isToday)', () => {
    expect(getTodayIsoInTimeZone(null)).toBeNull();
    expect(getTodayIsoInTimeZone('')).toBeNull();
    expect(getTodayIsoInTimeZone('   ')).toBeNull();
  });

  it('returns yyyy-MM-dd for a valid IANA zone', () => {
    const iso = getTodayIsoInTimeZone('UTC');
    expect(iso).toMatch(/^\d{4}-\d{2}-\d{2}$/);
  });

  it('returns null for invalid zone', () => {
    expect(getTodayIsoInTimeZone('Not/AZone')).toBeNull();
  });
});
