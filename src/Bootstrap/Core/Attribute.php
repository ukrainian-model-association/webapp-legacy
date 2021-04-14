<?php


namespace App\Bootstrap\Core;


class Attribute
{
    /** @var string */
    private $key;

    /** @var mixed */
    private $value;

    public function __construct($key, $value)
    {
        $this
            ->setKey($key)
            ->setValue($value);
    }

    public static function create($key, $value = null)
    {
        return new self($key, $value);
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return Attribute
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return Attribute
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
