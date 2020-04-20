<?php

namespace BenTools\Cache\Fallback;

use Psr\SimpleCache\CacheInterface;

final class CacheFallback implements CacheInterface
{
    /**
     * @var CacheInterface
     */
    private $main;

    /**
     * @var CacheInterface
     */
    private $fallback;

    public function __construct(CacheInterface $main, CacheInterface $fallback, CacheInterface ...$fallbacks)
    {
        $this->main = $main;
        $nextFallback = \array_shift($fallbacks);
        $this->fallback = null !== $nextFallback ? new self($fallback, $nextFallback, ...$fallbacks) : $fallback;
    }

    /**
     * @inheritDoc
     */
    public function get($key, $default = null)
    {
        try {
            return $this->main->get($key, $default);
        } catch (\Exception $e) {
            return $this->fallback->get($key, $default);
        }
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value, $ttl = null)
    {
        try {
            return $this->main->set($key, $value, $ttl);
        } catch (\Exception $e) {
            return $this->fallback->set($key, $value, $ttl);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete($key)
    {
        try {
            return $this->main->delete($key);
        } catch (\Exception $e) {
            return $this->fallback->delete($key);
        }
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        try {
            return $this->main->clear();
        } catch (\Exception $e) {
            return $this->fallback->clear();
        }
    }

    /**
     * @inheritDoc
     */
    public function getMultiple($keys, $default = null)
    {
        try {
            return $this->main->getMultiple($keys, $default);
        } catch (\Exception $e) {
            return $this->fallback->getMultiple($keys, $default);
        }
    }

    /**
     * @inheritDoc
     */
    public function setMultiple($values, $ttl = null)
    {
        try {
            return $this->main->setMultiple($values, $ttl);
        } catch (\Exception $e) {
            return $this->fallback->setMultiple($values, $ttl);
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple($keys)
    {
        try {
            return $this->main->deleteMultiple($keys);
        } catch (\Exception $e) {
            return $this->fallback->deleteMultiple($keys);
        }
    }

    /**
     * @inheritDoc
     */
    public function has($key)
    {
        try {
            return $this->main->has($key);
        } catch (\Exception $e) {
            return $this->fallback->has($key);
        }
    }
}
