#!/usr/bin/env sh
set -eu

# Work around PHP bug 71880 by streaming FPM logs through a clean FIFO.
rm -f /tmp/stdout
mkfifo /tmp/stdout
chmod 777 /tmp/stdout

tail -f /tmp/stdout &
exec php-fpm --nodaemonize --pid /tmp/php-fpm.pid -d error_log=/tmp/stdout
