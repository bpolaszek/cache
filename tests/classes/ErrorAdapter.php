<?php

namespace BenTools\Cache\Tests;

use Psr\SimpleCache\CacheInterface;

final class ErrorAdapter implements CacheInterface
{

    public function get($key, $default = null)
    {
        throw new \Exception('Nope.');
    }

    public function set($key, $value, $ttl = null)
    {
        throw new \Exception('Nope.');
    }

    public function delete($key)
    {
        throw new \Exception('Nope.');
    }

    public function clear()
    {
        throw new \Exception('Nope.');
    }

    public function getMultiple($keys, $default = null)
    {
        throw new \Exception('Nope.');
    }

    public function setMultiple($values, $ttl = null)
    {
        throw new \Exception('Nope.');
    }

    public function deleteMultiple($keys)
    {
        throw new \Exception('Nope.');
    }

    public function has($key)
    {
        throw new \Exception('Nope.');
    }
}
