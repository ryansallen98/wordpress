# Button group (Shadpine UI)

**Inspired by shadcn/ui:** [Button group](https://ui.shadcn.com/docs/components/radix/button-group)

Class strings mirror the **new-york-v4** registry ([`button-group.json`](https://ui.shadcn.com/r/styles/new-york-v4/button-group.json)): **`buttonGroupVariants`** on the root (including **select** + **`data-slot=select-trigger`** rules for future **`Select` in a group**), **`ButtonGroupText`** `cn()` string, and **`Separator`** + **`ButtonGroupSeparator`** overlay (see [separator](https://ui.shadcn.com/r/styles/new-york-v4/separator.json)).

**Presentational layout:** **`role="group"`** wrapper that visually merges adjacent **`<x-button>`** / **`<x-button.icon>`** borders (horizontal or vertical). Optional **`x-button-group.separator`** (decorative **`role="none"`** div; upstream uses Radix **`Separator`**) and **`x-button-group.text`**. No **`primitive/`** or Alpine.

**APG:** Label the group with **`aria-label`** (or **`aria-labelledby`**) when the purpose is not obvious from context alone.

## Files

| Role | Path |
|------|------|
| Root (`role="group"`) | `resources/views/components/button-group/index.blade.php` |
| Separator (`role="none"`) | `separator.blade.php` |
| Static label text | `text.blade.php` |
| Class tokens | `config/components/button_group.php` → **`config('components.button_group')`** |

## Usage (Blade)

```blade
<x-button-group aria-label="{{ __('Actions', 'sage') }}">
  <x-button type="button" variant="outline">{{ __('Archive', 'sage') }}</x-button>
  <x-button type="button" variant="outline">{{ __('Report', 'sage') }}</x-button>
</x-button-group>

<x-button-group>
  <x-button type="button" variant="secondary" size="sm">{{ __('Copy', 'sage') }}</x-button>
  <x-button-group.separator />
  <x-button type="button" variant="secondary" size="sm">{{ __('Paste', 'sage') }}</x-button>
</x-button-group>

<x-button-group orientation="vertical" class="h-fit" aria-label="{{ __('Zoom', 'sage') }}">
  <x-button.icon type="button" variant="outline" aria-label="{{ esc_attr__('In', 'sage') }}">
    <x-lucide-plus class="size-4" aria-hidden="true" />
  </x-button.icon>
  <x-button.icon type="button" variant="outline" aria-label="{{ esc_attr__('Out', 'sage') }}">
    <x-lucide-minus class="size-4" aria-hidden="true" />
  </x-button.icon>
</x-button-group>
```

- **`orientation`:** **`horizontal`** (default) or **`vertical`** on **`x-button-group`**.
- **`class`:** merged onto the root; use **`w-fit`**, **`h-fit`**, etc. as needed.
- **`x-button-group.separator`:** **`orientation`** **`vertical`** (default) = vertical rule in a horizontal row (matches upstream **`Separator`** `orientation`); **`horizontal`** for a rule in a vertical stack. Classes match **`Separator`** + **`ButtonGroupSeparator`** `cn()` merge.
- **`x-button-group.text`:** **`as`** = **`div`** (default), **`span`**, or **`label`** — same visual as **`ButtonGroupText`** (`bg-muted`, **`rounded-md`**, **`shadow-xs`**). For **`asChild`**-style composition (e.g. wrap a **`<label>`** with attributes), use **`as="label"`** and pass **`for`**, etc., on the component.
- **Nested **`x-button-group`:**** outer group gains **`gap-2`** between child groups (shadcn parity).

**`x-button`** sizes already include **`in-data-[slot=button-group]:rounded-lg`** in **`config/components/button.php`** so corners sit flush inside the group.

## Modifying

- **Layout / tokens:** **`config/components/button_group.php`** — `group` (base + `orientation`), `text`, `separator` (`radix` + `group` layers like upstream **`cn()`**).
- **Per-instance overrides:** pass **`class`** on any subcomponent; **`$tw->merge`** applies.

## Exporting

Copy **`button-group/*.blade.php`** and **`config/components/button_group.php`**. Ensure **`$tw`** is shared in views. Add **`@source`** for **`config/`** in Tailwind entry (see theme **`resources/css/app.css`**) so utility strings in PHP are discoverable.
