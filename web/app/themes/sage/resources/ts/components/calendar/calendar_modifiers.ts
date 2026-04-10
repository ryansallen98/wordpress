/** Normalize props to ISO date keys `yyyy-MM-dd`. */
export function parseCalendarIsoList(raw: unknown): Set<string> {
  if (!Array.isArray(raw)) {
    return new Set();
  }
  const out = new Set<string>();
  for (const item of raw) {
    const s = String(item).trim().slice(0, 10);
    if (/^\d{4}-\d{2}-\d{2}$/.test(s)) {
      out.add(s);
    }
  }
  return out;
}

/** `{ booked: ['2026-04-01'], ... }` → sets of ISO strings. */
export function parseCalendarModifierGroups(raw: unknown): Record<string, Set<string>> {
  if (raw == null || typeof raw !== 'object' || Array.isArray(raw)) {
    return {};
  }
  const out: Record<string, Set<string>> = {};
  for (const [key, value] of Object.entries(raw as Record<string, unknown>)) {
    if (typeof key !== 'string' || key === '') {
      continue;
    }
    out[key] = parseCalendarIsoList(value);
  }
  return out;
}

export function parseModifiersClassNames(raw: unknown): Record<string, string> {
  if (raw == null || typeof raw !== 'object' || Array.isArray(raw)) {
    return {};
  }
  const out: Record<string, string> = {};
  for (const [key, value] of Object.entries(raw as Record<string, unknown>)) {
    if (typeof key !== 'string' || key === '') {
      continue;
    }
    if (typeof value === 'string' && value.trim() !== '') {
      out[key] = value.trim();
    }
  }
  return out;
}
