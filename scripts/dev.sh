#!/usr/bin/env bash
set -euo pipefail

# Determine project root (one level up from this script)
ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

cd "$ROOT_DIR"

if [[ "${1:-}" == "--migrate" ]]; then
  echo "Running migrations before serving..."
  ./sail artisan migrate --force || true
fi

echo "Starting Laravel dev stack with Sail"
npx concurrently -c "#93c5fd,#c4b5fd,#fb7185,#fdba74" \
  "./sail artisan serve --host=0.0.0.0" \
  "./sail artisan queue:listen --tries=1" \
  "./sail artisan pail --timeout=0" \
  "npm run dev" \
  --names=server,queue,logs,vite --kill-others

