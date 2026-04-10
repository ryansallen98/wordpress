# Native select (Shadpine UI)

**Inspired by shadcn/ui:** [Native Select](https://ui.shadcn.com/docs/components/native-select)

Styled **`<select>`** with a chevron affordance. Prefer this over the Radix-style custom **Select** when you want **native** behavior, **mobile** pickers, or minimal JS. No Alpine factory — class tokens live in **`config/components/native_select.php`** (**`root.wrapper` / `select` / `icon`** for **`x-native-select`**; **`optgroup`** / **`option`** for sub-parts); **`App\View\Components\NativeSelect*`** merge and pass **`$wrapperClasses`** / **`$selectClasses`** / etc. into markup-only Blade.

## Files

| Role | Path |
|------|------|
| Wrapper + `<select>` + icon | `resources/views/components/native-select/index.blade.php` |
| `<option>` | `resources/views/components/native-select/option.blade.php` |
| `<optgroup>` | `resources/views/components/native-select/group.blade.php` |

## Usage (Blade)

```blade
<x-native-select name="status" class="max-w-xs" aria-label="{{ __('Status', 'sage') }}">
    <x-native-select.option value="">{{ __('Select status', 'sage') }}</x-native-select.option>
    <x-native-select.option value="todo">{{ __('Todo', 'sage') }}</x-native-select.option>
    <x-native-select.option value="done">{{ __('Done', 'sage') }}</x-native-select.option>
</x-native-select>
```

### Props (root `x-native-select`)

| Prop | Default | Notes |
|------|---------|--------|
| **`class`** | — | Merges onto the **wrapper** (default **`data-slot`** `native-select-wrapper`). |
| **`select-class`** | — | Merges onto the **`<select>`** only (e.g. extra control utilities). |
| **`icon-class`** | — | Merges onto the chevron SVG (e.g. smaller **`size-3.5`** for compact captions). |
| **`size`** | `default` | `default` or `sm` — sets **`data-size`** on wrapper and select for **`data-[size=sm]:`** tokens. |
| **`wrapper-data-slot`** | `native-select-wrapper` | Override **`data-slot`** on the outer div. |
| **`select-data-slot`** | `native-select` | Override **`data-slot`** on the **`<select>`**. |
| **`icon-data-slot`** | `native-select-icon` | Override **`data-slot`** on the chevron SVG. |

All **other** attributes (**`name`**, **`id`**, **`disabled`**, **`required`**, **`aria-invalid`**, **`multiple`**, **`x-model`**, etc.) are forwarded to the **`<select>`** via **`$attributes->except('class')`**. The **`<select>`** **`class`** attribute is **`$tw->merge($selectClasses, $attributes->get('class') ?? '')`** so config + **`select-class`** stay merged in PHP, and any **`class`** left on the forwarded bag (same pattern as other Shadpine class components) is merged in Blade.

### Options

```blade
<x-native-select.option value="a">{{ __('Label A', 'sage') }}</x-native-select.option>
<x-native-select.option value="b" :selected="true">{{ __('Label B', 'sage') }}</x-native-select.option>
<x-native-select.option value="c" disabled>{{ __('Disabled', 'sage') }}</x-native-select.option>
```

Use the **`selected`** prop (boolean) for the initially selected option, or rely on the parent **`value`** on the `<select>` in PHP/forms.

**`x-native-select.option` / `x-native-select.group`:** optional **`data-slot`** (prop **`data-slot`** / **`dataSlot`**) defaults to **`native-select-option`** and **`native-select-optgroup`**.

### Groups

```blade
<x-native-select name="role" aria-label="{{ __('Role', 'sage') }}">
    <x-native-select.option value="">{{ __('Select role', 'sage') }}</x-native-select.option>
    <x-native-select.group label="{{ __('Engineering', 'sage') }}">
        <x-native-select.option value="fe">{{ __('Frontend', 'sage') }}</x-native-select.option>
        <x-native-select.option value="be">{{ __('Backend', 'sage') }}</x-native-select.option>
    </x-native-select.group>
</x-native-select>
```

**`label`** is required for a meaningful **`<optgroup>`** (maps to the native **`label`** attribute).

## Accessibility

- Use a visible **`<label for="…">`** associated with the select’s **`id`**, or **`aria-label`** / **`aria-labelledby`** on **`x-native-select`** (forwarded to **`<select>`**).
- **`aria-invalid`** and **`disabled`** on the root apply to the native control.
- **APG:** [Select](https://www.w3.org/WAI/ARIA/apg/patterns/select/) — the browser implements listbox behavior for **`<select>`**; do not block native keyboard interaction.

## Copy in templates

When describing this control in **`{{ __('…') }}` / `{!! __('…') !!}`** strings, **do not** embed raw **`<select>`** (or other tags) inside **`{!! !!}`** outputs that sit in flow content — the browser will parse them as real elements and **break the DOM**. Use **`{{ }}`** (escaped), rephrase (“native select”, “HTML select”), or **`&lt;select&gt;`**.

## Modifying

- **Tokens:** edit **`config/components/native_select.php`** (**`root.wrapper`**, **`select`**, **`icon`**) and sub-keys for **`option`** / **`optgroup`**; PHP merges **`class`** / **`select-class`** / **`icon-class`** props via **`NativeSelect`**, **`Option`**, **`Group`**.
- **Root Blade:** **`index.blade.php`** — wrapper uses **`$wrapperClasses`**; **`<select>`** uses **`$tw->merge($selectClasses, $attributes->get('class') ?? '')`** plus **`$attributes->except('class')`** for the rest.
- **Chevron:** `x-lucide-chevron-down` in `index.blade.php`; icon uses **`end-2.5`** for RTL-friendly positioning.

## Exporting

Copy the three Blade files. Ensure **`$tw`** (TailwindMerge) is shared into views like this theme’s **`ThemeServiceProvider`**.
