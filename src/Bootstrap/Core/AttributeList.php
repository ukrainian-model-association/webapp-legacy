<?php


namespace App\Bootstrap\Core;


class AttributeList
{
    private $collection;

    public function add($attribute)
    {
        $this->collection[] = $attribute;

        return $this;
    }
}
