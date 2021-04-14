<?php

namespace App\Component;

interface BuilderInterface
{
    public static function create();

    public function build();
}