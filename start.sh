#!/usr/bin/env sh
set -e

# Run database migrations on deploy/start (Render free plan has no Shell).
php artisan migrate --force

# Start the app
php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"

