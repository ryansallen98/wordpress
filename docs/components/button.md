# Button (Shadpine UI)

**Inspired by shadcn/ui:** [Button](https://ui.shadcn.com/docs/components/button)

Buttons are **presentational** (no `primitive/`): polymorphic tag via `as`.

## Files

| Role | Path |
|------|------|
| Default button | `resources/views/components/button/index.blade.php` |
| Icon / square sizes | `resources/views/components/button/icon.blade.php` |
| Class tokens | `config/components/button.php` → `config('components.button')` |

## Usage (Blade)

```blade
<x-button variant="default" size="default">Label</x-button>
<x-button as="a" href="/contact" variant="outline">Link styled as button</x-button>
<x-button.icon variant="ghost" size="sm" aria-label="Open menu">
  <x-lucide-menu class="size-4" />
</x-button.icon>
```

- **`as`:** `button` (default), `a`, `span`, `div` — only `button` / `a` are inherently keyboard-accessible; use native elements for real actions.
- **`variant`:** `default`, `outline`, `secondary`, `ghost`, `destructive`, `link`.
- **`size`:** `default`, `xs`, `sm`, `lg`, `xl`, `2xl` (icon sizes differ for `button.icon` — see `icon_sizes` in config).

## Modifying

- **Variants / sizes:** edit `config/components/button.php` (primary place for CVA-style strings).
- **Wrapper markup:** edit `index.blade.php` / `icon.blade.php`; keep `$tw->merge` order: base → variant → size → `$attributes->get('class')`.

## Exporting

Copy `button/*.blade.php` and `config/components/button.php`; ensure Blade has `$tw` (TailwindMerge) shared into views like this theme’s `ThemeServiceProvider`.
