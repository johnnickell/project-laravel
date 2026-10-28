#!/usr/bin/env sh
set -eu

# One-off owning wrappers must execute their command and return its status, not start FPM.
if [ "$#" -gt 0 ]; then
    exec "$@"
fi

# Work around PHP bug 71880 by streaming FPM logs through a clean FIFO.
rm -f /tmp/stdout
mkfifo /tmp/stdout
chmod 777 /tmp/stdout

tail -f /tmp/stdout &
exec php-fpm --nodaemonize --pid /tmp/php-fpm.pid -d error_log=/tmp/stdout
