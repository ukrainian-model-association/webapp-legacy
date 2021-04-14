<?php

namespace App\Service;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigBuilder
{
    /** @var string|array */
    private $path;

    /** @var string */
    private $cacheDir;

    /** @var boolean */
    private $debug;

    public function __construct()
    {
        $basePath       = sprintf('%s/../..', __DIR__);
        $this->path     = sprintf('%s/templates', $basePath);
        $this->cacheDir = sprintf("%s/var/cache/twig", $basePath);
        $this->debug    = false;
    }

    public static function create()
    {
        return new self();
    }

    /**
     * @return Environment
     */
    public function build()
    {
        $loader  = $this->createFilesystemLoader($this->path);
        $options = [
            'cache'            => $this->cacheDir,
            'debug'            => $this->debug,
            'auto_reload'      => true,
            'strict_variables' => true,
        ];

        return new Environment($loader, $options);
    }

    private function createFilesystemLoader($path)
    {
        return new FilesystemLoader($path);
    }

    /**
     * @param false $debug
     *
     * @return TwigBuilder
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * @param string $path
     *
     * @return TwigBuilder
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @param string $cacheDir
     *
     * @return TwigBuilder
     */
    public function setCacheDir($cacheDir)
    {
        $this->cacheDir = $cacheDir;

        return $this;
    }
}
