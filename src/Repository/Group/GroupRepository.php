<?php

namespace App\Repository\Group;

use App\Model\Group\Group;

class GroupRepository
{
    /** @var string */
    private $class;

    public function __construct($class = Group::class)
    {
        $this->class = $class;
    }

    private function mapDataToEntity($row)
    {
        return $this
            ->createEntity()
            ->

    }

    /**
     * @return Group
     */
    private function createEntity()
    {
        return new $this->class;
    }
}