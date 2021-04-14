<?php

namespace App\Component\Spectator;

use App\Component\BuilderInterface;

class SpectatorBuilder implements BuilderInterface
{
    public static function create()
    {
        return new self();
    }

    public function build()
    {
        return new Spectator();
    }
}