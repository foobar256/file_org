#!/usr/bin/env bash
set -euo pipefail

# Wrapper to run any artisan command with the project-local PHP INI scan dir
ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
export PHP_INI_SCAN_DIR="$ROOT_DIR/.php/conf.d"

cd "$ROOT_DIR"
exec php artisan "$@"

