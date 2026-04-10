# Calendar (Shadpine UI)

**Inspired by shadcn/ui:** [Calendar](https://ui.shadcn.com/docs/components/radix/calendar) (built on **React DayPicker** upstream).

**This implementation** uses **Blade** markup, **Alpine.js** (`Alpine.data('calendar')`), and **date-fns** for month math and labels — no React. Visual tokens mirror the **new-york-v4** registry ([`calendar.json`](https://ui.shadcn.com/r/styles/new-york-v4/calendar.json)): root shell, **month and year pickers** (**`x-native-select`**, `size="sm"`) in one caption row — **borderless**, compact tokens from **`config/classes/calendar.php`** (**`caption_select_*`**), abbreviated month names (**`MMM`**) in the dropdown, full month in the **`sr-only`** live region. Prev/next icon buttons, weekday row, day grid, and day button `data-*` hooks for selection styling.

**Sync:** One Alpine state, **`visibleMonth`**, drives the **day grid** and **month/year `<select>`** values together. Initial month: **`selected`** (if set) → **`month`** (if set) → **today** — so a pre-selected date always opens in its own month; with no props, **single** and **range** both start on **the current month**.

**Markup:** Month and year **`<option>`** elements are **server-rendered in Blade** (valid HTML, works in every browser). Alpine only binds **`x-bind:disabled`** on month options and **`x-bind:value`** on the **`<select>`**s — do not use Alpine **`x-for`** on **`<option>`** (it often fails to expand).

**Toolbar:** Matches **React DayPicker / shadcn** layout: **`nav`** is a **direct child of the months container** (not inside the first month column) so **`absolute inset-x-0 top-0`** + **`justify-between`** place prev/next on the **far left and far right of the full multi-month strip**. **`pointer-events-none`** on the bar and **`pointer-events-auto`** on the buttons keeps the **center** usable for caption **`<select>`**s (single-month dropdown mode). The caption row (**`month_caption`**) stays in normal flow on the **first month** panel only, **centered**, with **`px-(--cell-size)`** (tighter **`px-1`** on small screens). **Tab order:** prev → next → month → year when dropdown caption is shown (**DOM** order matches that).

## Files

| Role | Path |
|------|------|
| Root (`data-slot="calendar"`) | `resources/views/components/calendar/index.blade.php` |
| Blade class component + view data | `app/View/Components/Calendar.php`, `app/View/Components/Calendar/ViewState.php` |
| Grid + selection logic | `resources/ts/components/calendar/calendar.ts` (+ **`index.ts`** barrel) |
| Pure month grid (tests) | `resources/ts/components/calendar/calendar_grid.ts` |
| **date-fns** locale whitelist + dynamic import | `resources/ts/components/calendar/calendar_locales.ts` |
| Modifier / disabled parsing (ISO lists) | `resources/ts/components/calendar/calendar_modifiers.ts` |
| **Today** in an IANA zone (`Intl`) | `resources/ts/components/calendar/calendar_timezone.ts` |
| Class tokens | `config/classes/calendar.php` → **`config('classes.calendar')`** |
| Min/max shortcuts (PHP) | `app/View/Components/Calendar/CalendarBounds.php` — **`mergeMinMaxWithOptions()`** (PHPUnit: **`tests/View/Components/Calendar/CalendarBoundsTest.php`**) |

### Portable bundle (other projects)

Copy these paths together; keep **`App\`** PSR-4 → **`app/`** (or adjust namespace + Composer autoload in the target project):

- `resources/views/components/calendar/index.blade.php`
- `app/View/Components/Calendar.php`
- `app/View/Components/Calendar/ViewState.php`
- `app/View/Components/Calendar/CalendarBounds.php`
- `resources/ts/components/calendar/**` (including **`index.ts`** barrel)
- `config/classes/calendar.php` — ensure Tailwind scans **`../../config/`** (this theme’s **`app.css`** **`@source`**)
- Register **`Alpine.data('calendar', calendar)`** in your entry (e.g. **`app.ts`**) and depend on **`date-fns`**
- Optional: PHPUnit **`tests/View/Components/Calendar/CalendarBoundsTest.php`**, **`ViewStateTest.php`** if you keep the same namespace

Also pull **`x-native-select`**, **`x-button`**, **`x-button.icon`**, and **`x-lucide-*`** (or replace in the Blade partial) if the target project does not already ship them.

## Usage (Blade)

```blade
{{-- Default: intrinsic width (w-fit) --}}
<x-calendar class="rounded-lg border" mode="single" selected="2026-04-08" />

<x-calendar mode="range" />

{{-- Open on a specific month before any range selection (no selected) --}}
<x-calendar mode="range" month="2026-01-01" />

{{-- Optional: stretch to container --}}
<x-calendar class="w-full rounded-lg border" mode="single" />

<x-calendar
  mode="single"
  week-starts-on="1"
  :show-outside-days="false"
  min="2026-04-01"
  max="2026-12-31"
/>

{{-- DX: no past dates (today inclusive). Uses same “today” as time-zone when set. --}}
<x-calendar mode="single" :disable-past="true" />

{{-- DX: no future dates (e.g. date-of-birth pickers). Combines with explicit min/max. --}}
<x-calendar mode="single" :disable-future="true" />

{{-- Explicit locale (otherwise uses app locale → same tag for Blade month options + Alpine) --}}
<x-calendar locale="fr" mode="single" />

{{-- Two months (label caption only; dropdown is single-month only), timezone, disabled + modifiers --}}
<x-calendar
  :number-of-months="2"
  time-zone="America/New_York"
  :disabled="$bookedDates"
  :modifiers="['booked' => $bookedDates]"
  :modifiers-class-names="['booked' => '[&>button]:line-through opacity-100']"
/>
```

### Props

| Prop | Type | Default | Notes |
|------|------|---------|--------|
| `mode` | `single` \| `range` | `single` | Range: first click sets start, second sets end (order normalized). |
| `week-starts-on` | `0` \| `1` | `0` | `0` = Sunday, `1` = Monday. |
| `show-outside-days` | bool | `true` | Show leading/trailing days from adjacent months. |
| `month` | string (parseable date) | — | Used **only when `selected` is empty** (e.g. range picker before first click): opens that month. If both are empty → **today**. |
| `selected` | string \| null | `null` | ISO `Y-m-d` — initial single day, or initial range anchor in `range` mode. When set, **always** sets the initial visible month to that date’s month (overrides **`month`**). |
| `min` / `max` | string \| null | `null` | Inclusive bounds; days outside are disabled; nav skips empty months. |
| `disable-past` | bool | `false` | When **`true`**, sets an effective **`min`** of **today** (ISO date) unless **`min`** is already stricter (later). **Today** stays selectable. **“Today”** uses **`time-zone`** when set (**`Carbon::now($tz)->toDateString()`**), else app default **`Carbon::today()`**. Implemented via **`App\View\Components\Calendar\CalendarBounds`**. |
| `disable-future` | bool | `false` | When **`true`**, sets an effective **`max`** of **today** unless **`max`** is already stricter (earlier). Same **today** rules as **`disable-past`**. |
| `locale` | string \| null | — | **BCP 47** tag (e.g. **`fr`**, **`en-GB`**, **`pt-BR`**); underscores become hyphens. When omitted, **`app()->getLocale()`** is used (hyphenated) so Blade month **`<option>`** labels and Alpine (**weekday row**, **`sr-only`** month line, day **`aria-label`**) stay aligned. Only **whitelisted** ids load extra **date-fns** chunks (see **`calendar_locales.ts`** / **`CALENDAR_SUPPORTED_LOCALE_IDS`**); unknown tags fall back to **`en-US`**. **`en-US`** stays synchronous; other locales load via **`import()`** and trigger a second **`refresh()`** when ready. |
| `number-of-months` | int | `1` | **1–12** consecutive months. Layout uses **`md:flex-row`** on the months container. Prev/next advance **one** month at a time (overlapping window, like **React DayPicker**). |
| `caption-layout` | `dropdown` \| `label` | `dropdown` | **`dropdown`** — month/year **`x-native-select`** when **`number-of-months` is 1** (ignored for **2+** months). **`label`** — read-only **`MMMM yyyy`**; with **2+** months, the first caption shows **`panelMonthLabel(0)`**, additional panels show their month under **`month_subcaption`**. |
| `time-zone` | string \| null | — | **IANA** name (e.g. **`America/New_York`**). Sets which calendar day is **“today”** (highlight + focus fallback) via **`Intl`**, and the **initial** visible month when **`selected`** and **`month`** are both empty (server uses **`Carbon::now($tz)`**). Also anchors **`disable-past`** / **`disable-future`** “today” on the server (**`Carbon::now($tz)->toDateString()`**). **Does not** re-interpret **`min`**/**`max`**/**`selected`** as zoned instants — values stay **date-only `Y-m-d`**. Omit for browser-local “today”. |
| `disabled` | string[] | `[]` | ISO **`Y-m-d`** dates that are **not selectable** (merged with **`min`**/**`max`**). |
| `modifiers` | `array<string, string[]>` | `[]` | Named groups of ISO dates for **styling** only unless the same dates also appear in **`disabled`**. Each day’s **`<td>`** gets **`data-modifiers="name1 name2"`** and extra classes from **`modifiers-class-names`**. |
| `modifiers-class-names` | `array<string, string>` | `[]` | Tailwind (or arbitrary) classes per modifier name, merged on the **`<td>`** (e.g. **`[&>button]:line-through`** targets the inner button). |
| `data-slot` | string | `calendar` | Override the root element’s **`data-slot`** (prop name **`dataSlot`** in Blade). |

Pass **`class`** on **`x-calendar`**; it merges onto the root with **`config('classes.calendar')['root']`**. The default root includes **`w-fit`** (same idea as shadcn’s **`DayPicker`** wrapper) so width follows the seven-column grid. To **fill a parent** (e.g. a full-width card), pass **`class="w-full"`** — Tailwind Merge resolves the conflict with **`w-fit`**.

### Events (Alpine `$dispatch` on the root element)

| Event | Detail |
|-------|--------|
| `calendar-select` | `{ iso: 'Y-m-d' }` — `mode="single"`. |
| `calendar-select-range` | `{ from: string \| null, to: string \| null }` — `mode="range"` (second click completes range). |

Example:

```blade
<div x-on:calendar-select="console.log($event.detail.iso)">
  <x-calendar mode="single" />
</div>
```

Alpine dispatches bubble to ancestors, so listen on a **wrapper** (or use **`$dispatch` targets** in your own **`x-data`** scope).

## Accessibility

- **Pattern:** [APG Date Picker Dialog](https://www.w3.org/WAI/ARIA/apg/patterns/dialog-modal/examples/datepicker-dialog/) (this widget is a **grid-only** slice; pair with a popover + text field for full pattern).
- **Implemented:** `role="grid"` / `role="row"` / `role="columnheader"` / `role="gridcell"`, **`aria-multiselectable`** (**`true`** in **`range`** mode, **`false`** in **`single`**), **`aria-label`** (per month panel, **`panelGridLabel`**) and **`aria-readonly="true"`** on each grid, **`aria-selected`** on day buttons, **`aria-current="date"`** for today, **`aria-disabled`** on prev/next when clamped, **`aria-live="polite"`** on the month caption. **Keyboard** listeners live on the **root** calendar element so multi-month views stay one focus scope.
- **Keyboard:** **Roving `tabindex`** — one day per grid uses **`tabindex="0"`**; others **`-1`** (Tab moves from nav buttons into the grid as a single stop, then out). **Arrow keys** move between enabled days (disabled days are skipped). When focus lands on a **leading/trailing outside day** from the **previous or next calendar month**, **`visibleMonth`** updates so that month becomes the main view (caption + grid) while staying within **min** / **max**. If there is **no next/previous cell in the DOM** (e.g. **`show-outside-days="false"`** so the grid is only in-month days, or the last week ends inside the month with no spill), **Arrow Right** / **Arrow Down** at the bottom-right edge or **Arrow Left** / **Arrow Up** at the top-left edge **advance** / **retreat** the month the same way as **Page Down** / **Page Up** (same **day-of-month** when it exists in the new month). **Home** / **End** move to the first / last enabled day in the **current week row**. **Page Up** / **Page Down** go to the previous / next month when allowed, keeping the same **day-of-month** when that date exists in the new month. **Enter** / **Space** activate the focused day (`<button>`). The same **month swap** runs when **focusing** or **clicking** an outside-month day (not only arrows). Month changes from the nav buttons restore focus to the roving day only when focus was already on a day button.

## Modifying

- **Tokens:** `config/classes/calendar.php`. Root **`--cell-size`** / **`--cell-radius`** match shadcn: **`[--cell-size:theme(spacing.7)]`**, **`[--cell-radius:var(--radius-md)]`**. Weekday and week **rows use `flex`** with **`flex-1`** cells (React DayPicker / registry parity), not CSS grid. Each **`month`** panel uses **`md:min-w-[calc(7*var(--cell-size))]`** so multi-month **`md:flex-row`** layouts do not compress below seven cells. Day buttons use **`relative isolate z-10`**, **`aspect-square`**, **`min-w-(--cell-size)`**, and **`rounded-(--cell-radius)`** like the [registry](https://ui.shadcn.com/r/styles/new-york-v4/calendar.json). For larger cells, override on **`x-calendar`**, e.g. **`[--cell-size:2.75rem]`** ([shadcn: custom cell size](https://ui.shadcn.com/docs/components/radix/calendar#custom-cell-size)).
- **Behavior / i18n:** `calendar_grid.ts` (weekday labels use **date-fns** `enUS` today); extend **`calendar()`** options for other locales later.

## Exporting

Copy **`calendar/`** Blade, **`resources/ts/components/calendar/`** (`calendar.ts`, **`calendar_grid.ts`**, helpers, **`index.ts`**, tests), register **`Alpine.data('calendar', calendar)`**, add **`date-fns`** to **`package.json`**, and keep **`@source "../../config/"`** in Tailwind so PHP class strings are scanned.

## See also

- [React DayPicker docs](https://react-day-picker.js.org/) (behavioral reference for parity).
- [date-fns](https://date-fns.org/) (formatting and date math).
