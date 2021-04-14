<?php

class cookie
{
    public static function delete($name)
    {
        self::set($name, null);
    }

    public static function set($name, $value, $expire = null, $path = null, $domain = null)
    {
        if (!$domain) {
            $domain = conf::get('server');
        }

        setcookie(md5($name), $value, $expire, $path, sprintf('.%s', $domain), true, false);
    }

    public static function get($name)
    {
        return $_COOKIE[md5($name)];
    }
}
