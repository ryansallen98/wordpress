# Alert (Shadpine UI)

**Inspired by shadcn/ui:** [Alert](https://ui.shadcn.com/docs/components/alert)

Alerts here are **presentational** (no `primitive/` subtree): static layout and variants only.

## Files

| Role | Path |
|------|------|
| Root | `resources/views/components/alert/index.blade.php` |
| Title / description / action | `title.blade.php`, `description.blade.php`, `action.blade.php` |
| Class tokens | `config/components/alert.php` → `config('components.alert')` |

## Usage (Blade)

```blade
<x-alert variant="destructive">
  <x-alert.title>Heading</x-alert.title>
  <x-alert.description>Supporting text.</x-alert.description>
  <x-alert.action>
    <x-button as="a" href="/">Action</x-button>
  </x-alert.action>
</x-alert>
```

- **`variant`:** `default` | `destructive` (see `config/components/alert.php`).
- **`role`:** default `alert`; override for `status` or other live region semantics if the copy is non-interruptive.

## Modifying

- **Colors / layout / grid:** edit `config/components/alert.php` and optionally slot components; merge with `$tw` in each Blade file.
- **Semantics:** prefer a real heading for the title when the outline matters: `<x-alert.title as="h2">`.

## Exporting

Copy `alert/*.blade.php` and `config/components/alert.php`; register Laravel config so `config('components.alert')` resolves (Acorn loads `config/components/*.php` as nested keys).
