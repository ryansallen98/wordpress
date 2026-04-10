# Badge (Shadpine UI)

**Inspired by shadcn/ui:** [Badge](https://ui.shadcn.com/docs/components/badge)

Badges are **presentational** (no `primitive/` subtree): small labels for status, counts, or metadata. Default element is **`span`** so copy stays non-interactive unless you opt into **`as`**.

## Files

| Role | Path |
|------|------|
| Default badge | `resources/views/components/badge/index.blade.php` |
| Class tokens | `config/components/badge.php` → `config('components.badge')` |

## Usage (Blade)

```blade
<x-badge>New</x-badge>
<x-badge variant="secondary">Draft</x-badge>
<x-badge variant="destructive">Error</x-badge>
<x-badge as="a" href="/tag/design" variant="outline">Design</x-badge>
```

- **`as`:** `span` (default), `a`, `button`, `div` — use **`a`** only with a real **`href`**; use **`button`** for actions and set **`type="button"`** when inside a form so you do not submit accidentally.
- **`variant`:** `default`, `secondary`, `destructive`, `outline`, `ghost`, `link` (see `config/components/badge.php`).
- **`data-slot`:** default `badge`; override via the `dataSlot` prop if you need a different slot marker for styling or tests.

## Accessibility

- **Static labels:** keep the default **`span`**; do not put essential information only in color—include visible text (or an accessible name on an icon badge).
- **Interactive badges:** prefer **`button`** or **`a`** with clear names; keyboard focus styles are included for those roles.

**APG:** N/A for the default non-interactive badge; for **`as="button"`**, follow the [Button pattern](https://www.w3.org/WAI/ARIA/apg/patterns/button/).

## Modifying

- **Variants:** edit `config/components/badge.php` (CVA-style strings).
- **Markup:** edit `index.blade.php`; keep `$tw->merge` order: **base → variant →** `$attributes->get('class')`.

## Exporting

Copy `badge/index.blade.php` and `config/components/badge.php`; ensure Blade has **`$tw`** (TailwindMerge) shared into views like this theme’s `ThemeServiceProvider`. Acorn loads `config/components/*.php` as nested keys (e.g. `config('components.badge')`).
