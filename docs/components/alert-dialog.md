# Alert dialog (Shadpine UI)

**Inspired by shadcn/ui:** [Alert Dialog](https://ui.shadcn.com/docs/components/radix/alert-dialog)

**Visual parity:** styled defaults follow the **current** shadcn registry ([`alert-dialog.tsx` in shadcn-ui/ui v4 new-york](https://github.com/shadcn-ui/ui/blob/main/apps/v4/registry/new-york-v4/ui/alert-dialog.tsx)) where practical — overlay (**`content.blade.php`**, e.g. **`bg-black/10`** + blur), panel **`group/alert-dialog-content`** + **`data-size`**, header/footer/title/description/media grid rules, etc. **`tw-animate-css`** enter/exit utilities use **`data-[state=open]:*`** / **`data-[state=closed]:*`** (see package README); overlay and panel set **`x-bind:data-state="open ? 'open' : 'closed'"`** so Blade does not treat **`:`** as PHP (same idea as **`x-on:click`** on components). The **portal** uses **`fixed inset-0 z-50`** (not **`contents`**) so the **`x-show`** node has a real box: Alpine’s **`x-transition`** leave phase waits for opacity, in sync with **`duration`** on **`x-alert-dialog.content`** (defaults to **`duration-100`**, passed through to **`primitive.portal`** **`enter-duration` / `leave-duration`** and the overlay/panel class strings). If **`leave-duration`** on the portal were shorter than the **`tw-animate`** exit, you’d get a flash when **`display: none`** runs early.

There is **no** **`config/classes/alert_dialog.php`**: upstream does not export a CVA map (unlike [Button](https://ui.shadcn.com/docs/components/radix/button), which exports **`buttonVariants`**). Default appearance strings live in **styled** partials with **`$tw->merge(..., $attributes->get('class'))`**.

**Pattern (same as `accordion/`):** **`primitive/`** = Radix-parity **Alpine + ARIA** only (minimal Tailwind). Sibling **styled** `*.blade.php` files = **Tailwind + `<x-alert-dialog.primitive.*>`**.

**APG:** [Alert and Message Dialogs pattern](https://www.w3.org/WAI/ARIA/apg/patterns/alertdialog/)

## Files

| Layer | Path |
|-------|------|
| **Primitive** `x-data` / `x-id` root | `primitive/root.blade.php` |
| **Styled** root (`display: contents`) | `index.blade.php` → `primitive.root` |
| **Primitive** open trigger | `primitive/trigger.blade.php` |
| **Styled** trigger | `trigger.blade.php` → `primitive.trigger` |
| **Primitive** teleport / trap / escape (portal shell) | `primitive/portal.blade.php` |
| **Primitive** backdrop (`x-bind:data-state` for **`tw-animate-css`**) | `primitive/overlay.blade.php` |
| **Primitive** `role="alertdialog"` panel | `primitive/content.blade.php` |
| **Styled** content (`$tw->merge` + composes portal → overlay + panel) | `content.blade.php` → **`primitive.portal`**, **`primitive.overlay`**, **`primitive.content`** |
| **Styled** only (layout `cn`) | `header.blade.php`, `footer.blade.php`, `media.blade.php` |
| **Primitive** title/description `x-bind:id` | `primitive/title.blade.php`, `primitive/description.blade.php` |
| **Styled** title/description | `title.blade.php`, `description.blade.php` → primitives |
| **Primitive** dismiss buttons | `primitive/cancel.blade.php`, `primitive/action.blade.php` |
| **Styled** cancel/action (**`config('classes.button')`**) | `cancel.blade.php`, `action.blade.php` → primitives |
| **Alpine state** | `resources/ts/components/alert_dialog/alert_dialog.ts` (+ **`index.ts`**) + **`app.ts`** |

## Usage (Blade)

Wrap **trigger** and **content** in **`x-alert-dialog`** so they share one Alpine scope.

```blade
<x-alert-dialog>
  {{-- Native wrapper (default as="span") + slotted control, or use Shadpine button as the trigger: --}}
  <x-alert-dialog.trigger as="x-button" variant="outline">Delete account</x-alert-dialog.trigger>

  <x-alert-dialog.content>
    <x-alert-dialog.header>
      <x-alert-dialog.media class="text-destructive">
        <x-lucide-trash-2 class="size-10" aria-hidden="true" />
      </x-alert-dialog.media>
      <x-alert-dialog.title>Are you sure?</x-alert-dialog.title>
      <x-alert-dialog.description>
        This cannot be undone. Your data will be removed from our servers.
      </x-alert-dialog.description>
    </x-alert-dialog.header>
    <x-alert-dialog.footer>
      <x-alert-dialog.cancel>Cancel</x-alert-dialog.cancel>
      <x-alert-dialog.action variant="destructive">Delete</x-alert-dialog.action>
    </x-alert-dialog.footer>
  </x-alert-dialog.content>
</x-alert-dialog>
```

- **`content` `size`:** `default` or `sm` — sets **`data-size`** on the content node for the same **`group-data-[size=*]/alert-dialog-content`** behavior as shadcn.
- **`content` `duration`:** Tailwind duration token (default **`duration-100`**) applied to overlay/panel **`tw-animate-css`** timing and to **`primitive.portal`** **`x-transition`** enter/leave so they stay aligned.
- **`default-open`:** pass **`true`** on **`x-alert-dialog`** when you need the dialog open on first paint (e.g. demos). It is **not** in styled **`index`** `@props` (so it stays on **`$attributes`** for the public API). The styled layer reads **`default-open` / `defaultOpen`** with **`$attributes->boolean(...)`** and passes **`:default-open`** into **`primitive.root`** — nested anonymous components do not reliably bind forwarded kebab attributes onto the child **`@props`** alone.
- **Dismissal:** **Escape** calls **`closeDialog()`** while `open` is true. **Backdrop clicks do not close** the dialog. **Cancel** / **Action** primitives use **`x-on:click`** (Blade-safe on native **`<button>`**).
- **Custom action / cancel logic:** pass **`x-on:click="…"`** on **`x-alert-dialog.action`** or **`x-alert-dialog.cancel`**. If your expression does **not** mention **`closeDialog`**, **`closeDialog()`** is appended after it (good for sync work). If it **does** mention **`closeDialog`** (e.g. **`$wire.delete().finally(() => closeDialog())`**), nothing is appended so you control when the dialog closes. **Forms:** use **`type="submit"`** on **`x-alert-dialog.action`** inside a **`<form>`**, or **`type="button"`** with **`x-on:click="$refs.id.requestSubmit()"`**. **Livewire:** forward **`wire:click`** from the styled button; defer closing with an **`x-on:click`** that calls **`closeDialog()`** only after **`$wire`…** when needed.
- **Trigger `as`:** **`span`** (default), **`button`**, **`a`**, or **`x-{component}`** (e.g. **`x-button`**, **`x-button.icon`**) — the part after **`x-`** is the Blade component name, same as in markup without the prefix. Native tags use **`@click`**; **`x-*`** triggers use **`x-on:click`** on the component tag (Blade-safe). Pass **`variant`**, **`size`**, **`aria-label`**, etc. on **`as="x-button"`** like any **`x-button`**. For a slotted **`x-button`** instead, keep **`as="span"`** (default) and put **`x-button`** in the slot.
- **Focus:** **`x-trap.noscroll.inert`** while open; **Cancel** **`autofocus`** by default (**`autofocus="false"`** to disable).

## Accessibility checklist (summary)

| Area | Behavior |
|------|-----------|
| Role | **`role="alertdialog"`**, **`aria-modal="true"`** on the panel |
| Name / description | **`aria-labelledby`** / **`aria-describedby`** wired to **`$id('title')`** and **`$id('description')`** |
| Keyboard | **Tab** cycles within the dialog; **Escape** dismisses (cancel path) |
| Focus | Trap + initial focus (**`autofocus`** on cancel by default); return focus after close |
| Motion | Enter/leave opacity uses **`motion-safe:`** on the portal shell |

## Modifying

- **Layout / appearance:** edit the class strings in the **`alert-dialog/*.blade.php`** partials; re-check the registry **`alert-dialog.tsx`** when shadcn updates.
- **Behavior:** `alert_dialog.ts` (`openDialog` / `closeDialog` / `defaultOpen`).
- **Related patterns** (teleport, `tw-animate-css`, Blade-safe Alpine): see **Porting checklist** in [`docs/components/INDEX.md`](INDEX.md).

## Exporting

Copy the `alert-dialog/` views and **`alert_dialog.ts`** + **`app.ts`** registration. No **`config/classes/alert_dialog.php`**. Load **`@alpinejs/focus`** and share **`$tw`** in Blade. Reuse **`config/classes/button.php`** for cancel/action if you keep the same button merge pattern.
