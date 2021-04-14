#!/usr/bin/env bash

/usr/local/opt/php@7.1/sbin/php-fpm \
    --nodaemonize \
    --allow-to-run-as-root \
    -c /usr/local/etc/php/7.1/php.ini \
    --fpm-config /usr/local/etc/php/7.1/php-fpm.conf

/usr/local/opt/php/sbin/php-fpm \
    --nodaemonize \
    --allow-to-run-as-root \
    -c /usr/local/etc/php/7.4/php.ini  \
    --fpm-config /usr/local/etc/php/7.4/php-fpm.conf
