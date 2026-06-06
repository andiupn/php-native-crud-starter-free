#!/usr/bin/env bash
set -euo pipefail

ensure_writable_path() {
  local path="$1"

  if [[ -d "$path" ]]; then
    chmod 0777 "$path" 2>/dev/null || true
    find "$path" -type d -exec chmod 0777 {} + 2>/dev/null || true
    find "$path" -type f -exec chmod 0666 {} + 2>/dev/null || true
    return
  fi

  local parent
  parent="$(dirname "$path")"
  mkdir -p "$parent"
  chmod 0777 "$parent" 2>/dev/null || true
  touch "$path"
  chmod 0666 "$path" 2>/dev/null || true
}

ensure_writable_path "/var/www/html/db"
ensure_writable_path "/var/www/html/db/database.sqlite"

exec "$@"
