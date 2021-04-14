<?php

namespace App\Component\UI;

class UIBuilder
{
    /** @var array */
    private $paths;

    public function __construct()
    {
        $this->paths = [];
    }

    public static function create()
    {
        return new self();
    }

    public function addPath($path)
    {
        $this->paths[] = $path;

        return $this;
    }

    public function build()
    {
        return new UI($this->paths);
    }
}
