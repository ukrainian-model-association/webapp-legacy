<?php

class db_connect
{
    protected static $connections = [];

    /**
     * @param null $alias
     * @param bool $force_connect
     *
     * @return PDO
     * @throws Exception
     */
    public static function get($alias = null, $force_connect = true)
    {
        if (!$alias) {
            $alias = conf::get('database_default_connection');
        }

        if (self::$connections[$alias] === null) {
            if ($force_connect) {
                return self::create($alias);
            }

            return false;
        }

        return self::$connections[$alias];
    }

    /**
     * @param null $alias
     * @param null $params
     *
     * @return mixed
     * @throws Exception
     */
    public static function create($alias = null, $params = null)
    {
        $log_id = (conf::get('enable_log'))
            ? logger::start($alias.' DB connecting ', 'DB connection')
            : null;

        if (!$alias) {
            $alias = conf::get('database_default_connection');
        }

        if (!$params) {
            $databases = conf::get('databases');

            if (!$databases[$alias]) {
                throw new Exception(sprintf('DB connection params for "%s" not found in configuration', $alias));
            }

            $params = $databases[$alias];
        }

        if (!$params['driver']) {
            $params['driver'] = 'mysql';
        }

        $uri = "{$params['driver']}:host={$params['host']}";

        if ($params['port']) {
            $uri .= ";port={$params['port']}";
        }

        if ($params['dbname']) {
            $uri .= ";dbname={$params['dbname']}";
        }

        self::$connections[$alias] = new PDO($uri, $params['user'], $params['password']);
        conf::get('enable_log') ? logger::commit($log_id) : null;

        if ($params['driver'] == 'mysql') {
            $statement = self::$connections[$alias]->prepare('SET NAMES utf8');
            $statement->execute();
        }

        return self::$connections[$alias];
    }
}