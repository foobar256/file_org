#!/usr/bin/env bash
set -euo pipefail

# Determine project root (one level up from this script)
ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

# Ensure PHP loads project-local extensions (SQLite)
export PHP_INI_SCAN_DIR="$ROOT_DIR/.php/conf.d"

# Default host/port (override with HOST/PORT envs)
HOST="${HOST:-127.0.0.1}"
PORT="${PORT:-8000}"

echo "Using PHP_INI_SCAN_DIR=$PHP_INI_SCAN_DIR"

# Quick sanity check for SQLite extensions
if ! php -m | grep -qi pdo_sqlite; then
  echo "Warning: pdo_sqlite not detected in current PHP module list." >&2
  echo "Modules: $(php -m | tr '\n' ' ')" >&2
  echo "Continuing anyway; if DB errors persist, check .php/conf.d/sqlite.ini." >&2
fi

cd "$ROOT_DIR"

if [[ "${1:-}" == "--migrate" ]]; then
  echo "Running migrations before serving..."
  php artisan migrate --force || true
fi

echo "Starting Laravel dev server at http://$HOST:$PORT"
exec php artisan serve --host "$HOST" --port "$PORT"

