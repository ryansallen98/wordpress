---
name: shadpine-ui
description: >-
  Shadpine UI: Alpine.js components inspired by shadcn/ui — Blade primitives
  in resources/views/components, TS in resources/ts/components, config/classes
  only when shadcn exports CVA (e.g. buttonVariants), Vitest. This repo uses
  Blade + Tailwind + $tw merge.
---

# Shadpine UI

**Shadpine UI** — Alpine components inspired by [shadcn/ui](https://ui.shadcn.com/). Same **primitive / styled** split as shadcn; markup can be ported to another templating stack (e.g. Astro); Tailwind can be swapped for traditional CSS if you adapt class maps.

**Rule:** `.cursor/rules/14-shadpine-ui.mdc` (mirror: `.claude/rules/`). **Catalog:** [`docs/components/INDEX.md`](../../../docs/components/INDEX.md).

## When to use

- New or updated **Shadpine UI** widgets aligned with a shadcn/ui component.
- Accordion, alert, button, or future dialog, menu, tabs, etc.

## Checklist (new interactive component)

1. **Parity:** identify the shadcn/ui component and props/slots to mirror.
2. **`primitive/`** — Radix-parity **behavior only**: roles, `aria-*`, keyboard handlers, **all Alpine** for the widget (`x-data` on root, `x-teleport`, `x-trap`, `x-show`, `@click` / `@keydown` on **plain HTML** in this file — not inside nested `<x-*>`). Minimal Tailwind; see **`accordion/primitive/`**.
3. **Styled layer** — **`data-slot` via `@props`** (defaults + **`data-slot="{{ $dataSlot }}"`**; use **`wrapperDataSlot` / `selectDataSlot`** when multiple nodes need slots — never bare hardcoded **`data-slot="…"`** only), **`$tw->merge(…)`**, composes **`<x-{name}.primitive.*>`** (e.g. **`accordion/trigger.blade.php`** → **`primitive.trigger`**). See **`.cursor/rules/14-shadpine-ui.mdc`** (`data-slot` policy).
4. **`config/classes/{name}.php`** **only** when shadcn exports CVA for reuse (e.g. **`buttonVariants`** on [Button](https://ui.shadcn.com/docs/components/radix/button)). Otherwise keep default **`cn(...)`** strings **in Blade**. Confirm classes against the **current** registry `*.tsx` (e.g. shadcn-ui `apps/v4/registry/.../ui/`), not stale docs from memory.
5. **`resources/ts/components/{name}/{name}.ts`** (+ **`index.ts`** re-exporting the factory) — `export function name(...)` for Alpine; register in **`app.ts`** via `import { name } from './components/{name}'` and `Alpine.data('name', name)`.
6. **`resources/ts/components/{name}/{name}.test.ts`** — Vitest coverage for state and helpers (colocated).
7. **`docs/components/{name}.md`** — APG link, props, file map; add a row to **`docs/components/INDEX.md`**.
8. **Verify:** `npm run lint`, `npm run test`, `npm run typecheck`, `npm run build` from theme directory.

## Project habit

- **Prefer** `resources/views/components/*` (Shadpine UI) instead of duplicate one-off markup.

## Related skills

- **`sage-frontend`** — Vite, Alpine plugins, `app.ts`.
- **`tailwindcss-development`** — tokens and utilities.
- **`testing-php-vitest`** — Vitest policy.
- **`linting-php-eslint`** — ESLint + Prettier.
