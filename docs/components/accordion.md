# Accordion (Shadpine UI)

**Inspired by shadcn/ui:** [Accordion](https://ui.shadcn.com/docs/components/accordion)  
**APG pattern:** [Accordion](https://www.w3.org/WAI/ARIA/apg/patterns/accordion/) (button + region disclosure)

## Files

| Role | Path |
|------|------|
| Root wrapper | `resources/views/components/accordion/index.blade.php` |
| Styled item / trigger / content | `item.blade.php`, `trigger.blade.php`, `content.blade.php` |
| Primitives | `primitive/root.blade.php`, `primitive/item.blade.php`, `primitive/trigger.blade.php`, `primitive/content.blade.php` |
| Alpine | `resources/ts/components/accordion/accordion.ts` (+ **`index.ts`** barrel) |
| Tests | `resources/ts/components/accordion/accordion.test.ts` |

**Plugins:** `@alpinejs/collapse` (panel animation), `@alpinejs/focus` available for related patterns.

## Usage (Blade)

```blade
<x-accordion type="single">
  <x-accordion.item>
    <x-accordion.trigger>Section title</x-accordion.trigger>
    <x-accordion.content>Panel content.</x-accordion.content>
  </x-accordion.item>
</x-accordion>
```

- **`type`:** `single` (one open) or `multiple` (several open).
- **`open`:** pass `open` on `x-accordion.item` to start expanded (primitive `item`).

## Modifying

- **Visuals (spacing, borders, chevron):** edit styled `trigger.blade.php`, `content.blade.php`, `item.blade.php` — use `$tw->merge($base, $attributes->get('class'))`.
- **Keyboard / ARIA / open logic:** edit `primitive/*` and **`accordion/accordion.ts`** together; update **`accordion/accordion.test.ts`** and re-check the APG accordion pattern.
- **Animation:** Styled `content.blade.php` uses a **CSS grid** open/close (`grid-rows-[0fr]` → `[1fr]` + `transition-[grid-template-rows]`) so height animates like shadcn/Radix **without** `h-auto` (not interpolable) and **without** Alpine Collapse. `prefers-reduced-motion` shortens duration via `motion-reduce:duration-0`. Optional alternative: set `--radix-accordion-content-height` from JS and use **`tw-animate-css`** utilities `animate-accordion-down` / `animate-accordion-up` on `data-[state=open|closed]:…` (see package README).

## Exporting

Copy the `accordion/` Blade tree, **`resources/ts/components/accordion/`** (`accordion.ts`, `index.ts`, `accordion.test.ts`), ensure `Alpine.data('accordion', accordion)` is registered in the target app’s `app.ts`.
