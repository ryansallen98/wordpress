---
name: testing-php-vitest
description: >-
  Mandatory PHPUnit and Vitest for the Sage theme and first-party plugins:
  composer test, test:integration, npm test, typecheck, where tests live, and
  when each suite runs.
---

# Testing (PHPUnit + Vitest)

**Rules:** `.cursor/rules/10-testing-mandatory.mdc`, **`13-mandatory-lint.mdc`**, `02-typescript-php-build.mdc`.

## Theme working directory

```bash
cd web/app/themes/{THEME_SLUG}
```

Current template: `sage`.

## PHP — PHPUnit

| Command | Purpose |
|---------|---------|
| `composer test` | Default suite — **no WordPress / no DB** (`tests/bootstrap.php` loads Composer autoload only). |
| `composer run test:integration` | Sets **`WP_INTEGRATION_TESTS=1`**, loads Bedrock **`wp-load.php`** — needs **`.env`** + database. Tests with `#[Group('integration')]`. |

- Config: **`phpunit.xml.dist`**, bootstrap **`tests/bootstrap.php`**.
- Override Bedrock root: **`BEDROCK_ROOT`** env var if the theme path is non-standard.
- New flexible/layout logic: **`tests/Flexible/`** (see **`acf-flexible`** skill).
- Use **`PHPUnit\Framework\Attributes\Group`** for groups (PHPUnit 11+).

## TypeScript — Vitest (Vite stack)

| Command | Purpose |
|---------|---------|
| `npm run test` | `vitest run` — must pass before shipping TS/JS behavior changes. |
| `npm run test:watch` | Local TDD. |
| `npm run typecheck` | `tsc --noEmit`. **`npm run build`** runs **`typecheck`** first so production builds fail on TS errors. |
| `npm run lint` | **ESLint** + Prettier **`format:check`** — mandatory when TS/JS or Prettier-scoped assets changed (**`13-mandatory-lint.mdc`**). |
| `npm run format:check` | Prettier only — also satisfied by **`npm run lint`**. |
| `composer run lint` / `lint:fix` | **Pint** — theme PHP (**`13-mandatory-lint.mdc`**, **`AGENTS.md`**). |
| `./vendor/bin/phpunit --filter=…` | Fast iteration; then **`composer test`** for full default suite. |

- Config: **`vitest.config.js`** (aliases align with **`vite.config.js`** / `@scripts`).
- Test globs: **`resources/**/*.{test,spec}.{js,ts}`** (covers colocated **`resources/ts/components/{name}/{name}.test.ts`** and similar).
- **`passWithNoTests: false`** — if you change TS, add or keep tests.

## Repo root shortcuts (optional)

From Bedrock root **`package.json`**: **`npm run test:theme`** runs theme Pint + PHPUnit + **`npm run lint`** (ESLint + Prettier check) + Vitest + typecheck.

## Done checklist (theme)

1. `composer run lint` (or `lint:fix` if theme PHP changed)
2. `composer test`
3. `npm run lint` (or `lint:fix` then `lint` if TS/JS or Prettier scope changed)
4. `npm run test`
5. `npm run typecheck`
6. `npm run build`
7. If you added WP-dependent tests: `composer run test:integration`

Do **not** delete tests without user approval. See **`AGENTS.md`**.

## Plugins

For **`web/app/plugins/{slug}/`**, add **`composer test`** / **`npm test`** when the package owns PHP or bundled TS — same “must pass before done” bar; document commands in that package’s README.
