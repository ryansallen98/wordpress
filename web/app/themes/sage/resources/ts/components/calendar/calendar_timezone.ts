/**
 * Calendar "today" in an IANA timezone using Intl (no extra deps).
 * Returns `null` when `timeZone` is empty or invalid — caller should use local `isToday`.
 */
export function getTodayIsoInTimeZone(timeZone: string | null | undefined): string | null {
  const z = timeZone != null ? String(timeZone).trim() : '';
  if (z === '') {
    return null;
  }
  try {
    const dtf = new Intl.DateTimeFormat('en-CA', {
      timeZone: z,
      year: 'numeric',
      month: '2-digit',
      day: '2-digit',
    });
    return dtf.format(new Date());
  } catch {
    return null;
  }
}
