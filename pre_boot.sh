#!/usr/bin/env bash

# This is intended to be used inside Docker

echo ""
echo "   [Nimbus] Pre-Boot..."
echo ""

php artisan config:cache
