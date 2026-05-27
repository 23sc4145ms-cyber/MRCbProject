#!/usr/bin/env sh
set -e

# Optional migrations (avoid slowing down cold starts).
# Set RUN_MIGRATIONS=1 in Render env vars when needed.
if [ "${RUN_MIGRATIONS:-0}" = "1" ]; then
  php artisan migrate --force
fi

# Start the app
php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"

#okay

