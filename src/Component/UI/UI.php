<?php

namespace App\Component\UI;

use ErrorException;
use PhpCollection\Map;

class UI
{
    /** @var Map */
    private $viewMap;

    /** @var array */
    private $paths;

    /** @var string */
    private $workingDirectory;

    /**
     * Renderer constructor.
     *
     * @param array $paths
     */
    public function __construct($paths)
    {
        $this->paths   = $paths;
        $this->viewMap = new Map();
    }

    /**
     * @param string $path
     * @param mixed  ...$args
     *
     * @return string
     */
    public function render($path, ...$args)
    {
        try {
            if (!$this->viewMap->containsKey($path)) {
                $resolvedPath = $this->resolvePath($path);
                if (null === $resolvedPath) {
                    throw new ErrorException(sprintf('Cannot resolve file path: %s', $resolvedPath));
                }
                $this->viewMap->set($path, require $resolvedPath);
            }

            /** @var callable $target */
            $target = $this->viewMap->get($path)->get();

            return call_user_func_array($target, $args);
        } catch (ErrorException $exception) {
            return sprintf('<div class="alert alert-danger">%s</div>', $exception->getMessage());
        }
    }

    /**
     * @param string $path
     *
     * @return null|string
     */
    public function resolvePath($path)
    {
        $paths = $this->paths;
        $wd    = $this->getWorkingDirectory();

        if (null !== $wd) {
            array_unshift($paths, $wd);
        }

        foreach ($paths as $basePath) {
            $absolutePath = sprintf('%s/%s.php', $basePath, $path);

            if (!file_exists($absolutePath)) {
                continue;
            }

            return $absolutePath;
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getWorkingDirectory()
    {
        return $this->workingDirectory ?: null;
    }

    /**
     * @param string $workingDirectory
     *
     * @return $this
     */
    public function setWorkingDirectory($workingDirectory)
    {
        $this->workingDirectory = $workingDirectory;

        return $this;
    }

    /**
     * @param callable $callable
     * @param array    $collections
     *
     * @return string
     */
    public function map($callable, ...$collections)
    {
        array_unshift($collections, $callable);

        return implode(PHP_EOL, call_user_func_array('array_map', $collections));
    }
}
