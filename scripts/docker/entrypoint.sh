#!/usr/bin/env bash

set -euo pipefail

runtime_dir="${BEDROCK_RUNTIME_DIR:-/var/lib/bedrock}"
runtime_env="${runtime_dir}/runtime.env"
app_root="${BEDROCK_APP_ROOT:-/var/www/vhosts/localhost/bedrock}"
uploads_dir="${app_root}/web/app/uploads"
mysql_socket="/run/mysqld/mysqld.sock"
mysql_pid_file="/run/mysqld/mariadb.pid"

random_hex() {
  openssl rand -hex "${1:-32}"
}

dotenv_escape() {
  local s="${1:-}"
  s="${s//\\/\\\\}"
  s="${s//\"/\\\"}"
  s="${s//$'\n'/\\n}"
  s="${s//$'\r'/}"
  printf '%s' "${s}"
}

write_bedrock_dotenv() {
  local dest="${app_root}/.env"

  umask 077
  {
    printf 'WP_ENV="%s"\n' "$(dotenv_escape "${WP_ENV}")"
    printf 'WP_HOME="%s"\n' "$(dotenv_escape "${WP_HOME:-}")"
    printf 'WP_SITEURL="%s"\n' "$(dotenv_escape "${WP_SITEURL:-}")"
    if [[ -n "${DATABASE_URL:-}" ]]; then
      printf 'DATABASE_URL="%s"\n' "$(dotenv_escape "${DATABASE_URL}")"
    else
      printf 'DB_HOST="%s"\n' "$(dotenv_escape "${DB_HOST}")"
      printf 'DB_NAME="%s"\n' "$(dotenv_escape "${DB_NAME}")"
      printf 'DB_USER="%s"\n' "$(dotenv_escape "${DB_USER}")"
      printf 'DB_PASSWORD="%s"\n' "$(dotenv_escape "${DB_PASSWORD}")"
    fi
    printf 'DB_PREFIX="%s"\n' "$(dotenv_escape "${DB_PREFIX:-wp_}")"
    printf 'AUTH_KEY="%s"\n' "$(dotenv_escape "${AUTH_KEY}")"
    printf 'SECURE_AUTH_KEY="%s"\n' "$(dotenv_escape "${SECURE_AUTH_KEY}")"
    printf 'LOGGED_IN_KEY="%s"\n' "$(dotenv_escape "${LOGGED_IN_KEY}")"
    printf 'NONCE_KEY="%s"\n' "$(dotenv_escape "${NONCE_KEY}")"
    printf 'AUTH_SALT="%s"\n' "$(dotenv_escape "${AUTH_SALT}")"
    printf 'SECURE_AUTH_SALT="%s"\n' "$(dotenv_escape "${SECURE_AUTH_SALT}")"
    printf 'LOGGED_IN_SALT="%s"\n' "$(dotenv_escape "${LOGGED_IN_SALT}")"
    printf 'NONCE_SALT="%s"\n' "$(dotenv_escape "${NONCE_SALT}")"
  } >"${dest}"

  chmod 600 "${dest}"
  chown 1000:1000 "${dest}" 2>/dev/null || true
}

write_runtime_env() {
  local db_name="${DB_NAME:-bedrock}"
  local db_user="${DB_USER:-bedrock}"
  local db_password="${DB_PASSWORD:-$(random_hex 24)}"
  local db_host="${DB_HOST:-127.0.0.1}"

  cat >"${runtime_env}" <<EOF
DB_HOST='${db_host}'
DB_NAME='${db_name}'
DB_USER='${db_user}'
DB_PASSWORD='${db_password}'
AUTH_KEY='$(random_hex 48)'
SECURE_AUTH_KEY='$(random_hex 48)'
LOGGED_IN_KEY='$(random_hex 48)'
NONCE_KEY='$(random_hex 48)'
AUTH_SALT='$(random_hex 48)'
SECURE_AUTH_SALT='$(random_hex 48)'
LOGGED_IN_SALT='$(random_hex 48)'
NONCE_SALT='$(random_hex 48)'
EOF

  chmod 600 "${runtime_env}"
}

load_runtime_env() {
  local incoming_db_host="${DB_HOST:-}"
  local incoming_db_name="${DB_NAME:-}"
  local incoming_db_user="${DB_USER:-}"
  local incoming_db_password="${DB_PASSWORD:-}"
  local incoming_database_url="${DATABASE_URL:-}"
  local incoming_auth_key="${AUTH_KEY:-}"
  local incoming_secure_auth_key="${SECURE_AUTH_KEY:-}"
  local incoming_logged_in_key="${LOGGED_IN_KEY:-}"
  local incoming_nonce_key="${NONCE_KEY:-}"
  local incoming_auth_salt="${AUTH_SALT:-}"
  local incoming_secure_auth_salt="${SECURE_AUTH_SALT:-}"
  local incoming_logged_in_salt="${LOGGED_IN_SALT:-}"
  local incoming_nonce_salt="${NONCE_SALT:-}"

  mkdir -p "${runtime_dir}" /run/mysqld /var/lib/mysql "${uploads_dir}" /var/www/vhosts/localhost/logs
  chown -R mysql:mysql /run/mysqld /var/lib/mysql
  # In dev we bind-mount the host repo at ${app_root}; recursively chown-ing the
  # mount (including .git objects) can fail with EPERM on macOS/ Docker Desktop.
  # Restrict ownership updates to runtime/writeable paths only.
  chown -R 1000:1000 "${runtime_dir}" "${uploads_dir}" /var/www/vhosts/localhost/logs 2>/dev/null || true

  rm -rf /var/www/vhosts/localhost/html
  ln -s "${app_root}/web" /var/www/vhosts/localhost/html

  if [[ ! -f "${runtime_env}" ]]; then
    write_runtime_env
  fi

  set -a
  # shellcheck disable=SC1090
  source "${runtime_env}"
  set +a

  export DATABASE_URL="${incoming_database_url:-${DATABASE_URL:-}}"
  export DB_HOST="${incoming_db_host:-${DB_HOST:-127.0.0.1}}"
  export DB_NAME="${incoming_db_name:-${DB_NAME}}"
  export DB_USER="${incoming_db_user:-${DB_USER}}"
  export DB_PASSWORD="${incoming_db_password:-${DB_PASSWORD}}"
  export AUTH_KEY="${incoming_auth_key:-${AUTH_KEY}}"
  export SECURE_AUTH_KEY="${incoming_secure_auth_key:-${SECURE_AUTH_KEY}}"
  export LOGGED_IN_KEY="${incoming_logged_in_key:-${LOGGED_IN_KEY}}"
  export NONCE_KEY="${incoming_nonce_key:-${NONCE_KEY}}"
  export AUTH_SALT="${incoming_auth_salt:-${AUTH_SALT}}"
  export SECURE_AUTH_SALT="${incoming_secure_auth_salt:-${SECURE_AUTH_SALT}}"
  export LOGGED_IN_SALT="${incoming_logged_in_salt:-${LOGGED_IN_SALT}}"
  export NONCE_SALT="${incoming_nonce_salt:-${NONCE_SALT}}"
  export DB_HOST="${DB_HOST:-127.0.0.1}"
  export WP_ENV="${WP_ENV:-development}"

  if [[ -n "${WP_HOME:-}" && -z "${WP_SITEURL:-}" ]]; then
    export WP_SITEURL="${WP_HOME%/}/wp"
  fi

  export DB_PREFIX="${DB_PREFIX:-wp_}"

  if [[ "${BEDROCK_USE_HOST_ENV:-0}" == "1" && -f "${app_root}/.env" ]]; then
    echo 'bedrock: BEDROCK_USE_HOST_ENV=1 and .env exists, using mounted host .env.' >&2
  else
    write_bedrock_dotenv
  fi
}

# Bundled MariaDB is used only when no DATABASE_URL and DB_HOST is loopback/local.
bedrock_embedded_mariadb() {
  if [[ -n "${DATABASE_URL:-}" ]]; then
    return 1
  fi

  case "${DB_HOST:-127.0.0.1}" in
    127.0.0.1 | localhost)
      return 0
      ;;
    *)
      return 1
      ;;
  esac
}

initialize_database_directory() {
  if [[ ! -d /var/lib/mysql/mysql ]]; then
    mariadb-install-db --user=mysql --datadir=/var/lib/mysql >/dev/null
  fi
}

start_temporary_database() {
  /usr/sbin/mariadbd \
    --user=mysql \
    --bind-address=127.0.0.1 \
    --datadir=/var/lib/mysql \
    --pid-file="${mysql_pid_file}" \
    --socket="${mysql_socket}" \
    --skip-networking &

  local attempts=0

  until mariadb-admin --socket="${mysql_socket}" ping >/dev/null 2>&1; do
    attempts=$((attempts + 1))

    if [[ ${attempts} -ge 30 ]]; then
      echo "MariaDB did not become ready in time." >&2
      exit 1
    fi

    sleep 1
  done
}

provision_database() {
  DB_NAME="${DB_NAME}" DB_USER="${DB_USER}" DB_PASSWORD="${DB_PASSWORD}" php <<'PHP' | mariadb --socket="${mysql_socket}"
<?php
declare(strict_types=1);

function quoteIdentifier(string $value): string
{
    return '`' . str_replace('`', '``', $value) . '`';
}

function quoteValue(string $value): string
{
    return "'" . str_replace("'", "''", $value) . "'";
}

$dbName = getenv('DB_NAME') ?: 'bedrock';
$dbUser = getenv('DB_USER') ?: 'bedrock';
$dbPassword = getenv('DB_PASSWORD') ?: '';

echo 'CREATE DATABASE IF NOT EXISTS ' . quoteIdentifier($dbName) . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
echo 'CREATE USER IF NOT EXISTS ' . quoteValue($dbUser) . "@'%' IDENTIFIED BY " . quoteValue($dbPassword) . ";\n";
echo 'ALTER USER ' . quoteValue($dbUser) . "@'%' IDENTIFIED BY " . quoteValue($dbPassword) . ";\n";
echo 'GRANT ALL PRIVILEGES ON ' . quoteIdentifier($dbName) . '.* TO ' . quoteValue($dbUser) . "@'%';\n";
echo "FLUSH PRIVILEGES;\n";
PHP
}

stop_temporary_database() {
  mariadb-admin --socket="${mysql_socket}" shutdown >/dev/null
}

main() {
  # Host `.env` / Compose often exports `DB_*` as empty strings. Bash `${VAR:-x}`
  # treats empty as "set", so defaults never apply; Bedrock Dotenv is immutable and
  # cannot override existing empty env vars. Unset empties so defaults work.
  for v in DB_HOST DB_NAME DB_USER DB_PASSWORD DATABASE_URL; do
    if [[ -z "${!v:-}" ]]; then
      unset "$v"
    fi
  done

  load_runtime_env

  if bedrock_embedded_mariadb; then
    export BEDROCK_EMBEDDED_MARIADB=1
    initialize_database_directory
    start_temporary_database
    provision_database
    stop_temporary_database
  else
    export BEDROCK_EMBEDDED_MARIADB=0
    echo 'bedrock: external database — skipping embedded MariaDB init (set DATABASE_URL or a non-local DB_HOST).' >&2
  fi

  exec "$@"
}

main "$@"
