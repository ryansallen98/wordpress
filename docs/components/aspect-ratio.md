# Aspect ratio (Shadpine UI)

**Inspired by shadcn/ui:** [Aspect ratio](https://ui.shadcn.com/docs/components/radix/aspect-ratio)

**Presentational only:** a **`relative w-full overflow-hidden`** wrapper with **`aspect-ratio`** set via inline **`style`** (so arbitrary ratios work without relying on Tailwind to see dynamic **`aspect-[…]`** class strings). No **`primitive/`** subtree and no Alpine module.

## Files

| Role | Path |
|------|------|
| Wrapper | `resources/views/components/aspect-ratio/index.blade.php` |

## Usage (Blade)

```blade
<x-aspect-ratio ratio="16/9" class="rounded-md border bg-muted">
  <img src="…" alt="" class="absolute inset-0 size-full object-cover" loading="lazy" />
</x-aspect-ratio>

<x-aspect-ratio ratio="square">
  {{-- slot content --}}
</x-aspect-ratio>
```

- **`ratio`:** **`16/9`** (default), presets **`video`** or **`16/9`**, **`square`** / **`1`** / **`1/1`**, or any positive **`width/height`** (e.g. **`4/3`**, **`21/9`**). Invalid values fall back to **`16/9`**.
- **`class`:** merged with **`$tw`** after base wrapper classes; use **`rounded-*`**, borders, background, etc. here.
- **`data-slot`:** default **`aspect-ratio`**; override with **`dataSlot`** if needed.
- **Media:** for a **cover** image, use **`absolute inset-0 size-full object-cover`** (or **`h-full w-full`**) on the **`<img>`** so it fills the box; add **`alt`** text for real content.

## Accessibility

- **Meaningful images:** provide descriptive **`alt`**; decorative images use **`alt=""`**.
- **No role** is required on the wrapper; it is a layout container only.

**APG:** N/A.

## Modifying

- **Defaults:** edit **`index.blade.php`** base classes or preset **`match`** branches.
- **Custom ratio from CMS:** pass a sanitized **`width/height`** string; only integers are accepted from the regex parser.

## Exporting

Copy **`aspect-ratio/index.blade.php`** and ensure **`$tw`** is available in Blade (theme **`ThemeServiceProvider`**). No **`config/classes`**, no **`app.ts`** entry.
