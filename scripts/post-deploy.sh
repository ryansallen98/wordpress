#!/bin/bash
set -euo pipefail

ROOT_DIR="${BEDROCK_APP_ROOT:-$(cd "$(dirname "$0")/.." && pwd)}"
cd "$ROOT_DIR"

WP=(wp --allow-root)

if ! "${WP[@]}" core is-installed --quiet 2>/dev/null; then
  echo "WordPress is not installed yet; skipping post-deploy."
  exit 0
fi

# Check if the theme is already active, and activate it if not
if ! "${WP[@]}" theme is-active sage; then
  echo "Activating the theme..."
  "${WP[@]}" theme activate sage
else
  echo "The theme is already active"
fi

# Check if the wp acorn command is available
if "${WP[@]}" acorn &> /dev/null; then
  echo "wp acorn command is available"

  # Clear Acorn cache before caching views
  echo "Clearing Acorn cache..."
  "${WP[@]}" acorn optimize:clear

  # Run wp acorn view:cache command
  echo "Running wp acorn view:cache..."
  if ! "${WP[@]}" acorn view:cache; then
    echo "Failed to cache views" >&2
    exit 1
  fi
else
  echo "wp acorn command is not available"
fi

# Flush permalinks to prevent 404s after deploy
echo "Flushing rewrite rules (permalinks)..."
"${WP[@]}" rewrite flush --hard
"${WP[@]}" cache flush || true

# In Docker, WP-CLI runs as root while OpenLiteSpeed PHP runs as uid 1000 (see Dockerfile).
# Acorn cache under web/app/cache must be readable by the web user or the front-end 500s.
if [[ "$(id -u)" -eq 0 ]] && [[ -d "${ROOT_DIR}/web/app/cache" ]]; then
  owner="$(stat -c '%u:%g' "${ROOT_DIR}/web/app" 2>/dev/null || echo '1000:1000')"
  chown -R "${owner}" "${ROOT_DIR}/web/app/cache"
fi
