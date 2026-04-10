# Breadcrumb (Shadpine UI)

**Inspired by shadcn/ui:** [Breadcrumb](https://ui.shadcn.com/docs/components/radix/breadcrumb)

**Presentational navigation:** `<nav>` + **`<ol>`** of **`<li>`** segments. No **`primitive/`** or Alpine module — compose with **`x-breadcrumb`**, **`x-breadcrumb.item`**, **`x-breadcrumb.link`**, **`x-breadcrumb.page`**, **`x-breadcrumb.separator`**, and optional **`x-breadcrumb.ellipsis`** for collapsed trails.

**APG:** [Breadcrumb pattern](https://www.w3.org/WAI/ARIA/apg/patterns/breadcrumb/)

## Files

| Role | Path |
|------|------|
| Root + list | `resources/views/components/breadcrumb/index.blade.php` |
| List item | `item.blade.php` |
| Segment link | `link.blade.php` |
| Current page (no link) | `page.blade.php` |
| Separator (`<li role="presentation">`) | `separator.blade.php` |
| Collapsed indicator | `ellipsis.blade.php` |

## Usage (Blade)

```blade
<x-breadcrumb>
  <x-breadcrumb.item>
    <x-breadcrumb.link :href="home_url('/')">{{ __('Home', 'sage') }}</x-breadcrumb.link>
  </x-breadcrumb.item>
  <x-breadcrumb.separator />
  <x-breadcrumb.item>
    <x-breadcrumb.link href="/docs">{{ __('Docs', 'sage') }}</x-breadcrumb.link>
  </x-breadcrumb.item>
  <x-breadcrumb.separator />
  <x-breadcrumb.item>
    <x-breadcrumb.page>{{ __('Current page', 'sage') }}</x-breadcrumb.page>
  </x-breadcrumb.item>
</x-breadcrumb>
```

- **`x-breadcrumb`:** Optional **`aria-label`** via prop **`ariaLabel`** (defaults to translated “Breadcrumbs”). Pass **`class`** to style the **`<ol>`** (merged with **`$tw`**). Optional **`nav-data-slot`** (default **`breadcrumbs`**) and **`list-data-slot`** (default **`breadcrumb-list`**) override root **`data-slot`** values for tests or nested layouts.
- **`x-breadcrumb.link`:** **`href`** (default **`#`** for demos only). **`class`** and other anchor attributes forward through **`$attributes`**.
- **`x-breadcrumb.page`:** Current segment — **`aria-current="page"`** on a **`<span>`** (not a link).
- **`x-breadcrumb.separator`:** Renders **`<li role="presentation" aria-hidden="true">`**. Default child is **`x-lucide-chevron-right`**; pass a slot for a custom icon (e.g. **`x-lucide-minus`**).
- **`x-breadcrumb.ellipsis`:** Place **inside** **`x-breadcrumb.item`** for a collapsed middle segment; includes **`sr-only`** “More breadcrumbs” for context if you expose equivalent links elsewhere.

## Composition

Alternate **`<x-breadcrumb.item>`** + **`<x-breadcrumb.separator />`** inside **`x-breadcrumb`**. The last segment should be **`x-breadcrumb.page`**; earlier segments use **`x-breadcrumb.link`**.

## Custom routing

Use **`href`** with **`home_url()`**, **`get_permalink()`**, or **`App\Support\WpLink`** as appropriate. To use a styled **`<x-button as="a">`** as the control, put it **inside** **`x-breadcrumb.item`** without **`x-breadcrumb.link`**, and keep keyboard/focus styles on the control.

## Modifying

- **Tokens:** edit class strings in each partial; keep **`$tw->merge(..., $attributes->get('class'))`** order.
- **Separator icon:** change the default in **`separator.blade.php`** or override per usage with a slot.

## Exporting

Copy the **`breadcrumb/`** Blade tree. Ensure **`$tw`** is available in views and **Lucide** Blade icons are installed for defaults.
