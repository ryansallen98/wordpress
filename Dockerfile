# syntax=docker/dockerfile:1.7

FROM composer:2 AS php_vendor

ENV COMPOSER_PROCESS_TIMEOUT=0

WORKDIR /app

COPY . .

# Coolify: pass as build arguments (same names as .env) so ACF Pro + ACFE Pro
# can install during composer install. Omitted vars skip COMPOSER_AUTH only.
ARG ACF_PRO_LICENSE_KEY
ARG WP_DOMAIN
ARG WP_HOME
ARG ACFE_PRO_KEY
ARG ACFE_PRO_URL
ENV ACF_PRO_LICENSE_KEY=$ACF_PRO_LICENSE_KEY \
    WP_DOMAIN=$WP_DOMAIN \
    WP_HOME=$WP_HOME \
    ACFE_PRO_KEY=$ACFE_PRO_KEY \
    ACFE_PRO_URL=$ACFE_PRO_URL

RUN if [ -z "${WP_HOME:-}" ] && [ -n "${WP_DOMAIN:-}" ]; then \
      export WP_HOME="https://${WP_DOMAIN}"; \
    fi \
 && if [ -z "${ACFE_PRO_URL:-}" ] && [ -n "${WP_DOMAIN:-}" ]; then \
      export ACFE_PRO_URL="${WP_DOMAIN}"; \
    fi \
 && if [ -n "${ACF_PRO_LICENSE_KEY:-}" ] && [ -n "${WP_HOME:-}" ]; then \
      export COMPOSER_AUTH="$(php /app/scripts/composer/export-composer-auth.php)"; \
    fi \
 && composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
 && cd web/app/themes/sage \
 && composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
 && printf '%s\n' '<?php' '// Docker image PHP may be older than lockfile-declared minimum; runtime checks skipped.' > vendor/composer/platform_check.php

FROM node:20-bookworm-slim AS theme_assets

WORKDIR /app/web/app/themes/sage

COPY web/app/themes/sage/package.json web/app/themes/sage/package-lock.json ./

RUN npm ci

COPY web/app/themes/sage ./

RUN npm run build

FROM litespeedtech/openlitespeed:latest AS runtime

ENV BEDROCK_APP_ROOT=/var/www/vhosts/localhost/bedrock \
    BEDROCK_RUNTIME_DIR=/var/lib/bedrock

RUN apt-get update \
 && apt-get install -y --no-install-recommends \
    mariadb-server \
    openssl \
    supervisor \
    unzip \
 && rm -rf /var/lib/apt/lists/*

# LiteSpeed PHP defaults to variables_order=GPCS, so $_ENV stays empty. Bedrock sets
# Env\Env::$options = 31 (USE_ENV_ARRAY), so env() reads $_ENV first and misses Docker
# / process env vars — DB_HOST falls back to localhost and breaks the bundled MariaDB.
RUN printf '\n; Bedrock: populate $_ENV from the environment for env() + Dotenv.\nvariables_order=EGPCS\n' >> /usr/local/lsws/lsphp83/etc/php/8.3/litespeed/php.ini

WORKDIR /var/www/vhosts/localhost/bedrock

COPY . /var/www/vhosts/localhost/bedrock
COPY --from=php_vendor /app/vendor /var/www/vhosts/localhost/bedrock/vendor
COPY --from=php_vendor /app/web/wp /var/www/vhosts/localhost/bedrock/web/wp
COPY --from=php_vendor /app/web/app/plugins /var/www/vhosts/localhost/bedrock/web/app/plugins
COPY --from=php_vendor /app/web/app/themes/sage/vendor /var/www/vhosts/localhost/bedrock/web/app/themes/sage/vendor
COPY --from=theme_assets /app/web/app/themes/sage/public/build /var/www/vhosts/localhost/bedrock/web/app/themes/sage/public/build
COPY scripts/docker/supervisord.conf /etc/supervisor/conf.d/bedrock.conf
COPY scripts/docker/entrypoint.sh /usr/local/bin/bedrock-entrypoint
COPY scripts/docker/mariadb-embedded-or-idle.sh /usr/local/bin/bedrock-mariadb-embedded-or-idle
COPY scripts/docker/litespeed-start.sh /usr/local/bin/litespeed-start
COPY scripts/docker/bedrock-post-deploy-when-ready.sh /usr/local/bin/bedrock-post-deploy-when-ready

RUN chmod +x /usr/local/bin/bedrock-entrypoint \
 && chmod +x /usr/local/bin/bedrock-mariadb-embedded-or-idle \
 && chmod +x /usr/local/bin/litespeed-start \
 && chmod +x /usr/local/bin/bedrock-post-deploy-when-ready \
 && mkdir -p /run/mysqld /var/lib/mysql "${BEDROCK_RUNTIME_DIR}" /var/log/supervisor /var/www/vhosts/localhost/logs /var/www/vhosts/localhost/bedrock/web/app/uploads /var/www/vhosts/localhost/bedrock/web/app/cache \
 && rm -rf /var/www/vhosts/localhost/html \
 && ln -s /var/www/vhosts/localhost/bedrock/web /var/www/vhosts/localhost/html \
 && chown -R mysql:mysql /run/mysqld /var/lib/mysql \
 && chown -R 1000:1000 /var/www/vhosts/localhost "${BEDROCK_RUNTIME_DIR}"

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --start-period=40s --retries=5 \
  CMD curl -fsS http://127.0.0.1/wp/wp-admin/install.php >/dev/null || exit 1

ENTRYPOINT ["bedrock-entrypoint"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/bedrock.conf"]
