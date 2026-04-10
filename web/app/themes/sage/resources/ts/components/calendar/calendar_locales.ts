import type { Locale } from 'date-fns';
import { enUS } from 'date-fns/locale/en-US';

/**
 * Whitelist of date-fns locales for the calendar. Each entry is a separate Vite chunk.
 * To add a locale: dynamic import `date-fns/locale/{path}` and use its **named** export
 * (TypeScript typings omit `default` on subpath imports).
 */
const localeLoaders = {
  'en-US': (): Promise<Locale> => Promise.resolve(enUS),
  'en-GB': (): Promise<Locale> => import('date-fns/locale/en-GB').then((m) => m.enGB),
  fr: (): Promise<Locale> => import('date-fns/locale/fr').then((m) => m.fr),
  'fr-CA': (): Promise<Locale> => import('date-fns/locale/fr-CA').then((m) => m.frCA),
  de: (): Promise<Locale> => import('date-fns/locale/de').then((m) => m.de),
  es: (): Promise<Locale> => import('date-fns/locale/es').then((m) => m.es),
  it: (): Promise<Locale> => import('date-fns/locale/it').then((m) => m.it),
  'pt-BR': (): Promise<Locale> => import('date-fns/locale/pt-BR').then((m) => m.ptBR),
  pt: (): Promise<Locale> => import('date-fns/locale/pt').then((m) => m.pt),
  nl: (): Promise<Locale> => import('date-fns/locale/nl').then((m) => m.nl),
  pl: (): Promise<Locale> => import('date-fns/locale/pl').then((m) => m.pl),
  ja: (): Promise<Locale> => import('date-fns/locale/ja').then((m) => m.ja),
  'zh-CN': (): Promise<Locale> => import('date-fns/locale/zh-CN').then((m) => m.zhCN),
  ko: (): Promise<Locale> => import('date-fns/locale/ko').then((m) => m.ko),
  ru: (): Promise<Locale> => import('date-fns/locale/ru').then((m) => m.ru),
  sv: (): Promise<Locale> => import('date-fns/locale/sv').then((m) => m.sv),
  nb: (): Promise<Locale> => import('date-fns/locale/nb').then((m) => m.nb),
  da: (): Promise<Locale> => import('date-fns/locale/da').then((m) => m.da),
  fi: (): Promise<Locale> => import('date-fns/locale/fi').then((m) => m.fi),
  tr: (): Promise<Locale> => import('date-fns/locale/tr').then((m) => m.tr),
  uk: (): Promise<Locale> => import('date-fns/locale/uk').then((m) => m.uk),
} as const;

export type CalendarLocaleId = keyof typeof localeLoaders;

export const CALENDAR_DEFAULT_LOCALE_ID: CalendarLocaleId = 'en-US';

/** Ids accepted after normalization (for docs / allowlists). */
export const CALENDAR_SUPPORTED_LOCALE_IDS = Object.keys(localeLoaders) as CalendarLocaleId[];

/**
 * Resolve a BCP 47–style tag (or `en`, `en_US`) to a whitelisted calendar locale.
 * Unknown values fall back to **en-US**. Region-only variants (e.g. `fr-FR`) fall back to the
 * primary language when it is whitelisted (`fr`).
 */
export function normalizeCalendarLocaleId(raw: string | null | undefined): CalendarLocaleId {
  const s = String(raw ?? CALENDAR_DEFAULT_LOCALE_ID)
    .trim()
    .replace(/_/g, '-');
  if (s === '' || s.toLowerCase() === 'en') {
    return CALENDAR_DEFAULT_LOCALE_ID;
  }
  if (s in localeLoaders) {
    return s as CalendarLocaleId;
  }
  const parts = s.split('-');
  if (parts.length >= 2) {
    const lang = parts[0]!.toLowerCase();
    if (lang === 'en') {
      return CALENDAR_DEFAULT_LOCALE_ID;
    }
    if (lang in localeLoaders) {
      return lang as CalendarLocaleId;
    }
  }
  return CALENDAR_DEFAULT_LOCALE_ID;
}

export function loadCalendarLocale(id: CalendarLocaleId): Promise<Locale> {
  return localeLoaders[id]();
}
