# Bedrock + Sage 11 — agent hub

**Agent conduct (skills activation, Pint, PHPUnit habits, what not to port from Laravel):** [`AGENTS.md`](AGENTS.md).

This repository is a **project starter template** for new projects.

**Author:** Ryan Allen — https://rallendev.com — https://github.com/ryansallen98

**Theme:** Sage 11–style (Roots). **`{THEME_SLUG}`** = **`sage`** here until you clone/rename (theme folder, text domain, Composer IDs, and all `{THEME_SLUG}` mentions in **`.cursor/rules/`**, this file, and **`.claude/skills/`**).

**Other tokens:** `{DEV_HOST}` (e.g. `myproject.test`), `{REFERENCE_PLUGIN}` (optional scaffold example, e.g. `logical-media-folders`).

---

## Cursor rules (canonical detail)

Stack rules live under **`.cursor/rules/*.mdc`** (authoritative copies also under **`.claude/rules/*.mdc`**). Cursor loads all `alwaysApply: true` rules every session; scoped rules apply when you work under matching globs. **Mirror policy, sync, drift checks, pre-commit:** [`.claude/rules/bedrock-sage-bootstrap.md`](.claude/rules/bedrock-sage-bootstrap.md).

| File | Scope | Contents |
|------|--------|----------|
| `00-template-context.mdc` | always | Template identity, tokens, doc checklist |
| `01-global-protocols.mdc` | always | Prime directive, verify-before-done, ULTRATHINK, design/TDD/ACF summary, APIs, hygiene |
| `02-typescript-php-build.mdc` | always | TS → JS, SCSS → CSS, tests, `strict_types` |
| `03-scaffold-git-versioning.mdc` | always | README, `.gitignore`, git init, naming, authorship, versions, `changelog.txt` |
| `04-wordpress-plugins.mdc` | `web/app/plugins/**` | Plugin scaffold, templates, overrides |
| `05-theme-php-blade-acf.mdc` | `web/app/themes/**/*.php` | Support, Integrations, Features, ACF, Blade/composers, `@php` safety |
| `06-theme-alpine-vite.mdc` | `web/app/themes/**/*.{blade.php,ts,css}` | Alpine + TS, Vite, Tailwind v4, WCAG gate |
| `07-docs-stack-pointers.mdc` | always | Docs map, MCP, skills index |
| `08-acorn-php-laravel.mdc` | `web/app/themes/**/*.php` | Acorn: DI, `config()`, security for HTTP/DB, what **not** to use (Eloquent-by-default, etc.) |
| `09-blade-laravel-components.mdc` | `web/app/themes/**/*.blade.php` | Laravel Blade: `$attributes->merge`, components vs `@include`, `@pushOnce`, `@aware` |
| `10-testing-mandatory.mdc` | always | Mandatory PHPUnit + Vitest; theme `composer test` / `test:integration`; `npm run test` / `typecheck` |
| `11-frontend-formatting.mdc` | always | EditorConfig + mandatory Prettier (+ Tailwind class sort); not for Blade/PHP |
| `12-acf-blocks.mdc` | always | ACFE Gutenberg blocks: `block.php`, `resources/views/blocks/`, `Composers/Blocks`, `tests/Blocks` |
| `13-mandatory-lint.mdc` | always | Mandatory Pint (theme PHP) + ESLint (theme TS/JS); `npm run lint` = ESLint + Prettier check |
| `14-shadpine-ui.mdc` | always | **Shadpine UI** — Alpine kit inspired by shadcn/ui; `primitive/`, TS, Vitest; `config/classes` only when shadcn exports CVA (e.g. `buttonVariants`); Blade in this template |

When you change a topic, edit the **matching `.mdc`** or skill, run **`./scripts/sync-agent-mirrors.sh`**, and keep this hub’s **tokens and table** accurate after renames.

---

## Claude Code skills (workflows)

Skills: **`.claude/skills/`** (authoritative); **`.cursor/skills/`** is the Cursor copy — see **[`bedrock-sage-bootstrap.md`](.claude/rules/bedrock-sage-bootstrap.md)** for sync direction.

| Skill | When to use |
|-------|----------------|
| `bedrock-sage` | Repo layout, `./scripts/setup.sh`, root `composer run lint`, theme `npm`/`composer`, Acorn, post-deploy |
| `sage-frontend` | Theme `npm run dev/build/typecheck`, tokens, `app.ts`, Alpine glob, a11y |
| `acf-flexible` | ACF JSON sync, `flexible.php`, flexible composers, PHPUnit |
| `deploy-scripts` | CI, `THEME_DIR`, lockfiles, `npm ci`, view cache after Blade changes |
| `wordpress-plugins` | New first-party plugin scaffold, templates, enqueue, strict PHP/TS |
| `acorn-laravel` | Laravel patterns inside Sage/Acorn (DI, `config()`, Str/Collection, Blade components); excludes Eloquent-by-default |
| `tailwindcss-development` | Tailwind v4 in the theme (`@theme`, `@import`, utilities in Blade); spacing/layout/dark mode |
| `testing-php-vitest` | PHPUnit default + integration suites, Vitest for `resources/ts`, root `npm run test:theme` |
| `prettier-tailwind` | Prettier + `prettier-plugin-tailwindcss`; `npm run format` / `format:check`; root `npm run format:theme` |
| `linting-php-eslint` | Theme Pint + ESLint; `eslint.config.js`; `npm run lint` / `lint:fix`; root `npm run test:theme` includes both |
| `acf-blocks` | `block.php` → `resources/views/blocks/`; new-block checklist in **`12-acf-blocks.mdc`**; `Composers/Blocks`, `tests/Blocks` |
| `shadpine-ui` | **Shadpine UI**: shadcn/ui–inspired Alpine components; primitives, styled Blade, TS + Vitest; `config/classes` only for exported CVA (e.g. button) |

Hub entrypoint: `.claude/CLAUDE.md` → this file.

---

## `.claude/rules/`

**[`bedrock-sage-bootstrap.md`](.claude/rules/bedrock-sage-bootstrap.md)** — mirror contract, sync/check scripts, pre-commit, CI (not duplicated in `.claude/CLAUDE.md`).

---

## Optional per-clone rules

Committed **stubs** (replace with real product/ops context per project):

- `.claude/rules/site-product.md` — mission, audience, goals  
- `.claude/rules/project-memory.md` — deploy quirks, IA, paths  

**Claude Code:** `.claude/settings.json` (team-style permissions); **`.claude/settings.local.json`** for personal overrides — add to **`.gitignore`** if you create it (not committed).

---

*Detailed stack protocols live in `.cursor/rules/*.mdc` and skills above — not duplicated in full here.*
