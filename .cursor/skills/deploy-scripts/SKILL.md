---
name: deploy-scripts
description: >-
  Deploy and CI patterns for Bedrock + Sage: THEME_DIR, npm ci, theme build,
  composer install, Acorn view cache. Customize per host and repo.
---

# Deploy scripts & CI

**Customize** paths and Node version for each clone. **Cursor rule index:** `07-docs-stack-pointers.mdc`.

## Local

- **Setup:** `./scripts/setup.sh` from repo root (includes theme `npm run build` and `post-deploy.sh` when configured).
- **Server:** adjust `scripts/post-deploy.sh` (Composer in theme if `vendor/` not committed, theme activate, `wp acorn optimize:clear`, rewrite flush, object cache, etc.).

## CI (typical)

- This repo: **`.github/workflows/theme-tests.yml`** — theme `composer install`, `npm ci`, **`npm run format:check`**, **`composer test`**, **`npm run test`**, **`npm run typecheck`** (no DB required for default PHPUnit suite).
- Deploy workflow path varies — e.g. `.github/workflows/deploy-prod.yml`.
- **Env:** `THEME_DIR=web/app/themes/{THEME_SLUG}` (currently `sage` in this template).
- **Order (pattern):** checkout → setup Node → `npm ci` + `npm run build` **in theme directory** → optional strip `node_modules` from artifact → `composer install` at root (and in theme if it has its own `composer.json`) → deploy (rsync, etc.).

## Lockfiles & cache

- GitHub Actions (or similar): `cache-dependency-path` must include the **theme** `package-lock.json` (and root lockfiles if used).
- Prefer **`npm ci`** in CI, not `npm install`.

## Blade / Acorn

After Blade or Acorn changes, ensure the pipeline still runs **`wp acorn view:cache`** (or equivalent) if you rely on cached views in production.

## Node version

Pin in `.nvmrc`, `package.json` `engines`, or CI matrix — **update this skill** when the template is cloned and versions differ.
