# Skeleton (Shadpine UI)

**Inspired by shadcn/ui:** [Skeleton](https://ui.shadcn.com/docs/components/skeleton)

A **non-interactive** loading placeholder: pulsing block you size with **`class`** (e.g. **`h-4 w-full`**, **`size-10 rounded-full`**). No **`primitive/`** or Alpine.

## Files

| Role | Path |
|------|------|
| Placeholder | `resources/views/components/skeleton/index.blade.php` |
| Class tokens | `config/components/skeleton.php` → **`config('components.skeleton')`** (**`root`**) |

## Usage (Blade)

```blade
<x-skeleton class="h-4 w-full" />
<x-skeleton class="size-12 shrink-0 rounded-full" />
<div class="space-y-2">
  <x-skeleton class="h-4 w-[250px]" />
  <x-skeleton class="h-4 w-[200px]" />
</div>
```

- **`class`:** set **width**, **height** (or **`size-*`**), **shape** (`rounded-full` for avatars); merged after **`root`** via **`$tw`**.
- **`data-slot`:** default **`skeleton`**; override with the **`dataSlot`** prop when needed.

## Accessibility

- Treat as **decorative** while loading: prefer **`aria-busy="true"`** (and optionally **`aria-label`**) on a **parent** wrapper; announce loaded content when it replaces the skeleton.
- Prefer **`motion-reduce:animate-none`** on the token string (included in **`root`**) so reduced-motion users are not subjected to continuous pulse.

**APG:** N/A (presentational placeholder).

## Modifying

- **Tokens:** edit **`config/components/skeleton.php`** (**`root`**).
- **Markup:** edit **`index.blade.php`**; keep **`$tw->merge($classes, $attributes->get('class') ?? '')`** after **`$attributes->except`**.

## Exporting

Copy **`skeleton/index.blade.php`** and **`config/components/skeleton.php`**; ensure **`$tw`** is shared (e.g. **`ThemeServiceProvider::boot`**). Add **`@source`** for **`config/`** in the theme CSS entry if utilities in PHP should be scanned.
