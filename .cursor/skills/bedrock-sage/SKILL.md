---
name: bedrock-sage
description: >-
  Bedrock + Sage monorepo layout, setup scripts, root Composer lint, theme
  directory commands, Acorn/WP-CLI, Blade @php rule of thumb. THEME_SLUG is
  sage in this template until renamed.
---

# Bedrock + Sage

**Rules:** `.cursor/rules/00-template-context.mdc`, `01-global-protocols.mdc`, `07-docs-stack-pointers.mdc`, **`10-testing-mandatory.mdc`**, **`11-frontend-formatting.mdc`**, **`13-mandatory-lint.mdc`**, **`12-acf-blocks.mdc`**. **Theme PHP/ACF:** `05-theme-php-blade-acf.mdc`, `08-acorn-php-laravel.mdc`. **Blade (Laravel components):** `09-blade-laravel-components.mdc`. **Theme assets:** `06-theme-alpine-vite.mdc`. **Skills:** `acorn-laravel`, `tailwindcss-development`, **`testing-php-vitest`**, **`prettier-tailwind`**, **`linting-php-eslint`**, **`acf-flexible`**, **`acf-blocks`**.

## Layout

- **Bedrock:** `web/wp/`, `web/app/`, `config/application.php`, `.env` (`.env.example`).
- **Theme:** `web/app/themes/{THEME_SLUG}/` — Acorn in `functions.php`, `app/Providers/`, `app/Snippets/` (core), `app/Integrations/{Vendor}/snippets/` (vendor-only), `app/Support/`, `App\View\Composers/`.

## Repo root

```bash
./scripts/setup.sh                # Composer + theme deps + npm run build + post-deploy
./scripts/sync-agent-mirrors.sh   # after editing .cursor/rules/*.mdc or .claude/skills/
composer run lint
composer run lint:fix
npm run test:theme          # theme: pint + composer test + eslint+prettier check + vitest + tsc
npm run format:theme        # Prettier check only (theme)
```

## MCP (Cursor / Claude Code)

**`.cursor/mcp.json`** and root **`.mcp.json`**: WP-CLI/Acorn stdio server plus optional **Context7**, **Playwright**, **GitHub** (reads **`.env`** via dotenv-cli), **Perplexity** — see **`docs/mcp.md`**. WP-CLI server one-time: **`cd scripts/mcp-wp-acorn && npm ci`**.

## Claude Code layout

**`.claude/settings.json`** — shared permissions; **`.claude/settings.local.json`** — personal (gitignored). Optional **`.claude/rules/site-product.md`** / **`project-memory.md`** for product/ops prose (stubs in template; not mirrored from `.cursor/`).

## Theme directory (`web/app/themes/{THEME_SLUG}/`)

```bash
composer run lint           # Pint (check)
composer run lint:fix       # Pint (fix) — run after editing app/**/*.php
npm run dev
npm run build
composer test               # PHPUnit (default; no DB)
composer run test:integration   # PHPUnit + WordPress (needs .env + DB)
./vendor/bin/phpunit --filter=YourTest   # iterate one test
npm run lint                # ESLint + Prettier check
npm run lint:fix            # ESLint fix + Prettier --write
npm run format:check        # Prettier
npm run format              # Prettier --write
npm run test                # Vitest
npm run typecheck
```

**Agent habits:** root **`AGENTS.md`** (skills activation, verification, Vite, docs policy).

`npm run translate:*` if configured.

## Acorn / WP-CLI

```bash
wp acorn optimize:clear
wp acorn view:cache
```

## Deploy

Customize `scripts/post-deploy.sh` per host. For CI patterns see skill **deploy-scripts**.

## Blade (one rule)

Never mix `@php(expr)` with `@php` … `@endphp` in the same file — full detail in `05-theme-php-blade-acf.mdc`.

## Quality

When `docs/quality-audits.md` exists: follow lint, typecheck/build, WCAG 2.2 AAA for interactive UI. **Always** run theme **`composer test`**, **`npm run test`**, and **`npm run typecheck`** before calling UI/PHP work done — see **`testing-php-vitest`**.
