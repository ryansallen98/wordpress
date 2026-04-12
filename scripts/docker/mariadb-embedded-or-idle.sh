#!/usr/bin/env bash
# Runs bundled MariaDB when BEDROCK_EMBEDDED_MARIADB=1; otherwise keeps the
# supervisord program slot alive without listening (external DB in use).

set -euo pipefail

if [[ "${BEDROCK_EMBEDDED_MARIADB:-1}" != "1" ]]; then
  echo "bedrock: BEDROCK_EMBEDDED_MARIADB=0 — skipping bundled MariaDB (external DATABASE_URL or DB_HOST)."
  exec sleep infinity
fi

exec /usr/sbin/mariadbd \
  --user=mysql \
  --bind-address=127.0.0.1 \
  --datadir=/var/lib/mysql \
  --pid-file=/run/mysqld/mariadb.pid \
  --socket=/run/mysqld/mysqld.sock
