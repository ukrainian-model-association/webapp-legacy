<?php

namespace App\Bootstrap\Core;

class ClassList
{
    private $collection;

    public function __construct($collection = [])
    {
        $this->collection = $collection;
    }

    public function add($class)
    {
        $this->collection[] = $class;

        return $this;
    }

    public function remove($class)
    {
        if ($this->has($class)) {
            $offset = array_search($class, $this->collection);
            array_splice($this->collection, $offset, 1);
        }

        return $this;
    }

    public function has($class)
    {
        return in_array($class, $this->collection);
    }

    public function __toString()
    {
        return implode(' ', $this->collection);
    }
}
