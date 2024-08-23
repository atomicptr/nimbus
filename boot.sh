#!/usr/bin/env bash

# This is intended to be used inside Docker

echo ""
echo "   [Nimbus] Starting..."
echo ""

php artisan config:cache
php artisan octane:start --port=8000 &

pid=$!

trap 'kill -SIGINT $pid; wait $pid' SIGINT
trap 'kill -SIGTERM $pid; wait $pid' SIGTERM
wait $pid
