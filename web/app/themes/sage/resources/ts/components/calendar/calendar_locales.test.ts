import { describe, expect, it } from 'vitest';

import {
  CALENDAR_DEFAULT_LOCALE_ID,
  loadCalendarLocale,
  normalizeCalendarLocaleId,
} from './calendar_locales';

describe('normalizeCalendarLocaleId', () => {
  it('defaults empty to en-US', () => {
    expect(normalizeCalendarLocaleId(null)).toBe(CALENDAR_DEFAULT_LOCALE_ID);
    expect(normalizeCalendarLocaleId('')).toBe(CALENDAR_DEFAULT_LOCALE_ID);
  });

  it('maps bare en to en-US', () => {
    expect(normalizeCalendarLocaleId('en')).toBe(CALENDAR_DEFAULT_LOCALE_ID);
  });

  it('accepts hyphen ids and underscores', () => {
    expect(normalizeCalendarLocaleId('fr')).toBe('fr');
    expect(normalizeCalendarLocaleId('fr_FR')).toBe('fr');
    expect(normalizeCalendarLocaleId('en-GB')).toBe('en-GB');
  });

  it('falls back for unknown tags', () => {
    expect(normalizeCalendarLocaleId('xx-YY')).toBe(CALENDAR_DEFAULT_LOCALE_ID);
  });
});

describe('loadCalendarLocale', () => {
  it('loads French locale', async () => {
    const loc = await loadCalendarLocale('fr');
    expect(loc.code).toBe('fr');
  });
});
