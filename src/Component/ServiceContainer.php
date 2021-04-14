<?php

namespace App\Component;

class ServiceContainer
{
    private $map = [];

    public function register($key, $serviceProvider)
    {
        $this->map[$key] = $serviceProvider;

        return $this;
    }

    public function get($key)
    {
        if (!$this->has($key)) {
            throw new RuntimeException('Service not found');
        }

        return $this->map[$key];
    }

    public function has($key)
    {
        return array_key_exists($key, $this->map);
    }

    public function call($key, ...$args)
    {
        return call_user_func_array($this->map[$key], $args);
    }
}