<?php

namespace App\Component\Asset;

/**
 * Class AssetManager
 */
class AssetManager
{
    /** @var Set */
    private $bag;

    /**
     * AssetManager constructor.
     */
    public function __construct()
    {
        $this->bag = new Set();
    }

    /**
     * @return AssetManager
     */
    public static function create()
    {
        return new self();
    }

    public function bind(Asset $asset)
    {
        $this->bag->add($asset);
    }

    public function findByType($type)
    {
        return $this->bag->filter(
            static function (Asset $asset) use ($type) {
                return $asset->getType() === $type;
            }
        );
    }
}
