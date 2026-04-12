# Bedrock + Sage (Extended Starter)

**Opinionated WordPress starter stack combining Bedrock and Sage, with
Alpine.js, Blade Icons, and WooCommerce support out of the box.**

This is a public starter repository that bundles the Roots Bedrock
WordPress stack together with the Sage starter theme, preconfigured for
modern Laravel-style WordPress development.

Instead of wiring everything together manually for each project, this
repo gives you a ready-to-go foundation.

## ✨ What's Included

### WordPress Stack (Bedrock)

-   🧱 Bedrock-based WordPress structure
-   🔐 Environment-based configuration (.env)
-   📦 Composer-managed WordPress core, plugins, and themes
-   🚀 Production-ready deployment structure

### Theme Stack (Sage)

-   🔧 Laravel Blade templating
-   ⚡️ Vite-powered modern frontend workflow
-   🎨 Tailwind CSS configured by default
-   🧩 Alpine.js included and wired up
-   🎯 Blade Icons pre-installed and configured
-   🛒 WooCommerce-ready theme setup
-   📦 Block editor support
-   🚀 Acorn integration for Laravel-style features

## Why This Starter?

The goal of this starter is to eliminate repetitive setup when starting
new WordPress projects:

-   No more setting up Bedrock from scratch
-   No more installing Sage separately
-   No more manually adding Alpine.js, Blade Icons, or WooCommerce
    compatibility

Clone once. Build fast. Ship clean.

## Docker + Coolify

This starter now includes a Docker runtime that is friendly to local
`docker compose` usage and Dockerfile deployments such as Coolify.

-   The container runs OpenLiteSpeed, PHP, and can run an internal MariaDB
    instance for local Docker Compose.
-   It is designed so the WordPress LiteSpeed Cache plugin can run against a
    LiteSpeed-compatible server instead of Apache.
-   On first boot it creates a database, generates WordPress salts, and persists
    them under `/var/lib/bedrock` when the bundled MariaDB is enabled.
-   `WP_SITEURL` is derived automatically from `WP_HOME` when not provided.
-   Uploads, database files, and generated runtime secrets are designed to live
    on persistent volumes.
-   After WordPress is installed (installer or WP-CLI), Supervisor runs
    `scripts/post-deploy.sh` once: activate the Sage theme, Acorn optimize/view
    cache when available, flush rewrites.
-   Local `compose.yml` explicitly enables the bundled MariaDB with
    `BEDROCK_ALLOW_EMBEDDED_MARIADB=1`.
-   Production deployments should use an external persistent MySQL/MariaDB
    service. The container now refuses to boot with the bundled MariaDB unless
    `BEDROCK_ALLOW_EMBEDDED_MARIADB=1` is set explicitly.

### Local container usage

```bash
npm run docker:dev
```

That starts the app on `http://localhost:8080` by default.

Useful commands:

-   `npm run docker:build`
-   `npm run docker:start`
-   `npm run docker:stop`

### Coolify setup

Use the repository as a Dockerfile application.

Recommended production setup:

-   Create a dedicated MySQL/MariaDB service in Coolify.
-   Point this app at that database with `DATABASE_URL`, or with `DB_HOST`,
    `DB_NAME`, `DB_USER`, and `DB_PASSWORD`.
-   Do not rely on the bundled MariaDB for production. It is a local-development
    convenience and is blocked by default unless you explicitly opt in.

Set these runtime environment variables in Coolify:

-   `WP_HOME`
-   `WP_ENV`
-   `DATABASE_URL` or `DB_HOST`
-   `DB_NAME`
-   `DB_USER`
-   `DB_PASSWORD`

Optional overrides:

-   `WP_SITEURL`
-   `DB_PREFIX`
-   `DB_HOST` — for a Coolify-managed database, use the internal service
    hostname Coolify provides, not `host.docker.internal`.

If you install premium plugins during the image build, set the ACF Pro
build-time vars in Coolify:

-   `ACF_PRO_LICENSE_KEY`

ACF Extended Pro is not installed through Composer in this starter anymore.
Track it separately as a private plugin repository or submodule at
`web/app/plugins/acf-extended-pro` so Docker and Coolify copy it into the image
with the rest of the app code.

If you intentionally override the production recommendation and enable the
bundled MariaDB with `BEDROCK_ALLOW_EMBEDDED_MARIADB=1`, add persistent storage
for:

-   `/var/lib/mysql`
-   `/var/lib/bedrock`
-   `/var/www/vhosts/localhost/bedrock/web/app/uploads`

Without those mounts, redeploys can recreate the container with a fresh
internal database and reset the site.

After the first deploy, WordPress will have its database and salts ready; if
the site has not been installed yet, the normal WordPress installer will take
over in the browser.

## Quick Start

```bash
git clone https://github.com/ryansallen98/wordpress
cd wordpress
npm run setup
```

## Credits

This project is built on top of:

-   Roots Bedrock
-   Roots Sage
-   Roots Acorn

Massive credit to the Roots team for pushing modern WordPress
development forward.

## License

MIT (inherits upstream licenses from Roots projects)
