<?php


namespace App\Component\Asset;

use App\Common\Utils\StringUtils;
use PhpCollection\Set as BaseSet;

class Set extends BaseSet
{
    public function __toString()
    {
        return implode(StringUtils::EOL, $this->all()) . StringUtils::EOL;

    }
}
