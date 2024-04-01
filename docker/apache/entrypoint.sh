#!/bin/sh
composer install --no-interaction --prefer-dist
exec apache2-foreground
