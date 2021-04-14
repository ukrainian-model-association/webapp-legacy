<?php

namespace App\DB;

class Query
{
    private $sql;

    private $context;

    private $executor;

    /**
     * Query constructor.
     *
     * @param string $sql
     * @param array  $context
     */
    public function __construct($sql, $context = [])
    {
        $this->executor = ['db', 'get_cols'];
        $this->sql      = $sql;
        $this->context  = $context;
    }

    public static function create($sql = '', $context = [])
    {
        return new self($sql, $context);
    }

    public function setParameter($parameter, $value)
    {
        $this->context[$parameter] = $value;

        return $this;
    }

    public function execute()
    {
        return call_user_func($this->executor, $this->sql, $this->context);
    }

    /**
     * @return string
     */
    public function getSql()
    {
        return $this->sql;
    }

    /**
     * @param string $sql
     *
     * @return Query
     */
    public function setSql($sql)
    {
        $this->sql = $sql;

        return $this;
    }
}
