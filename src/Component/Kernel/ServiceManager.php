<?php

namespace App\Component\Kernel;

use Doctrine\Common\Collections\ArrayCollection;

class ServiceManager
{
    /** @var ServiceManager */
    private static $instance;

    /** @var ArrayCollection */
    private $services;

    /** @var ArrayCollection */
    private $providers;

    private function __construct()
    {
        $this->providers = new ArrayCollection();
        $this->services  = new ArrayCollection();
    }

    public static function i()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $namespace
     * @param callable $provider
     * @return $this
     */
    public function addProvider($namespace, $provider)
    {
        $this->providers->set($namespace, $provider);

        return $this;
    }

    /**
     * @param string $namespace
     * @return mixed|null
     */
    public function get($namespace)
    {
        if (!$this->services->containsKey($namespace)) {
            $this->services->set($namespace, call_user_func($this->providers->get($namespace)));
        }

        return $this->services->get($namespace);
    }
}