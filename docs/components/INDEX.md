# Shadpine UI — component catalog

**Shadpine UI** is an **Alpine.js** component kit **inspired by [shadcn/ui](https://ui.shadcn.com/)**. The ideas are **portable**: you need **Alpine**, a **templating layer**, and styling (**Tailwind** here with PHP **Tailwind Merge** as `$tw`; you could use plain CSS or another utility setup). **This repository** implements Shadpine UI with **Blade** under the Sage theme.

**Stack rules:** [`.cursor/rules/14-shadpine-ui.mdc`](../../.cursor/rules/14-shadpine-ui.mdc) · **Skill:** `shadpine-ui`

**Theme paths** (replace `sage` if the theme was renamed):

- Styled components: `web/app/themes/sage/resources/views/components/{name}/`
- Primitives (a11y + behavior): `web/app/themes/sage/resources/views/components/{name}/primitive/`
- Alpine logic: `web/app/themes/sage/resources/ts/components/{name}/` — **`{name}.ts`** + **`index.ts`** barrel (registered in `resources/ts/app.ts`)
- Shared class maps: `web/app/themes/sage/config/components/{name}.php`

## Conventions (quick)

| Layer | Change styling here | Change behavior / ARIA here |
|-------|---------------------|------------------------------|
| Styled | `config/components/{name}.php` + `app/View/Components/{Name}/*.php` (merge only); `{name}/*.blade.php` markup | Avoid — delegate to primitive |
| Primitive | Minimal classes only | `{name}/primitive/*.blade.php` |
| State / keyboard | — | `{name}/{name}.ts` + primitive event bindings |

- Override consumer classes: pass `class="..."` on the component; primitives/styled use **`$tw->merge(..., $attributes->get('class'))`**.
- **Accessibility:** every new interactive primitive must pass the checklist in **`14-shadpine-ui.mdc`**; each component doc below lists the APG pattern and files.

## Component list

| Component | shadcn/ui reference | Documentation |
|-----------|---------------------|---------------|
| Accordion | [Accordion](https://ui.shadcn.com/docs/components/accordion) | [accordion.md](accordion.md) |
| Alert | [Alert](https://ui.shadcn.com/docs/components/alert) | [alert.md](alert.md) |
| Alert dialog | [Alert Dialog](https://ui.shadcn.com/docs/components/radix/alert-dialog) | [alert-dialog.md](alert-dialog.md) |
| Aspect ratio | [Aspect ratio](https://ui.shadcn.com/docs/components/radix/aspect-ratio) | [aspect-ratio.md](aspect-ratio.md) |
| Badge | [Badge](https://ui.shadcn.com/docs/components/badge) | [badge.md](badge.md) |
| Breadcrumb | [Breadcrumb](https://ui.shadcn.com/docs/components/radix/breadcrumb) | [breadcrumb.md](breadcrumb.md) |
| Button | [Button](https://ui.shadcn.com/docs/components/button) | [button.md](button.md) |
| Button group | [Button group](https://ui.shadcn.com/docs/components/radix/button-group) | [button-group.md](button-group.md) |
| Calendar | [Calendar](https://ui.shadcn.com/docs/components/radix/calendar) | [calendar.md](calendar.md) |
| Native select | [Native Select](https://ui.shadcn.com/docs/components/native-select) | [native-select.md](native-select.md) |

## Adding a component

1. Pick the shadcn/ui widget and APG pattern (if interactive).
2. Add `primitive/` only when the widget needs managed focus, ARIA, or Alpine state.
3. Add `resources/ts/components/{name}/{name}.ts`, **`index.ts`** (barrel: `export * from './{slug}';` matching the implementation filename), and colocated **`{name}.test.ts`** when there is TS state.
4. Add `config/components/{name}.php` for **all** Tailwind tokens consumed from PHP (CVA maps when shadcn exports them, plus inline `cn(...)` parity strings otherwise). **No** utility strings in `app/View/Components/**/*.php`.
5. Register Alpine in `resources/ts/app.ts`.
6. Add **`docs/components/{name}.md`** and a row in the table above.
7. Add a **subsection with examples** to the **Shadpine UI kit** block in **`resources/views/index.blade.php`** (home template) so the live catalog stays complete.
8. Run theme **`npm run lint`**, **`npm run test`**, **`npm run typecheck`**, **`npm run build`** when TS/Blade change.

### Porting checklist — overlays, teleport, `tw-animate-css`

Use this for **dialogs, drawers, popovers**, and anything with **teleport + exit animations** (patterns exercised by **Alert dialog** + **Accordion**):

| Topic | Do this |
|-------|---------|
| **Alpine vs Blade** | Prefer **`x-on:`** / **`x-bind:`** on **primitives** and on attributes forwarded through Blade components. **`@click`** / **`:attr="expr"`** can be parsed as Blade directives or PHP; native **`<button>`** / **`<a>`** in primitives are the usual safe place for **`@click`**. |
| **`tw-animate-css`** | Follow the package README: variants like **`data-[state=open]:animate-in`** / **`data-[state=closed]:animate-out`**, not ad hoc **`data-open:`** unless you know Tailwind generated it. Bind state with **`x-bind:data-state="…"`** (Alpine), not raw **`:data-state`** if Blade steals **`:`**. |
| **Portal + `x-show`** | The teleported shell that uses **`x-show` + `x-transition`** must be a **real box** (e.g. **`fixed inset-0 z-50`**), not **`display: contents`**, or Alpine may end the leave phase immediately and **flash** while child keyframes still run. Keep **portal transition duration** aligned with overlay/panel **`duration-*`** (see **`x-alert-dialog.content`** **`duration`** prop → **`primitive.portal`**). |
| **Primitive modularity** | Split **portal**, **overlay**, and **panel** into separate **`primitive/*.blade.php`** files when the shell grows; **primitives** stay **ARIA + behavior + minimal structure** — default product Tailwind lives in **`config/components/{name}.php`** and styled **`View/Components`** merges. |
| **Polymorphic trigger** | **`as="x-{name}"`** → **`<x-dynamic-component :component="…">`** where the component name is the part after **`x-`** (e.g. **`x-button.icon`** → **`button.icon`**). **`span` / `button` / `a`** stay on a **dynamic HTML tag** branch; use **`x-on:click`** on Blade component triggers. |
| **Composing `x-button`** | Inside **alert** actions, **native `<button>` + `config('components.button')`** avoids nested **`x-button`** + Blade **`@` / `@if` in tags** foot-guns. Prefer **slots** or this pattern until you have a verified **`asChild`-style** API. |
| **Action clicks** | Merge consumer **`x-on:click`** with **`closeDialog()`** (or omit auto-append when the expression already mentions **`closeDialog`**) for sync vs async dismiss; support **`type="submit"`** when the action sits in a **`<form>`**. |

Reference implementations: **`accordion/`** ( disclosure, **`data-[state=open|closed]`** on content), **`alert-dialog/`** (trap, teleport, **`alert_dialog.ts`**, **`docs/components/alert-dialog.md`**).
