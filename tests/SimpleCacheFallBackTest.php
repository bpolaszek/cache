<?php

namespace BenTools\Cache\Tests;

use BenTools\Cache\Fallback\CacheFallback;
use Cache\Adapter\PHPArray\ArrayCachePool;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;

final class SimpleCacheFallBackTest extends TestCase
{
    /**
     * @test
     * @dataProvider generateInstances
     */
    public function it_falls_back(CacheInterface $cache)
    {
        $this->assertTrue($cache->has('foo'));
        $this->assertEquals('bar', $cache->get('foo'));

        $cache->set('foo', 'foobar');
        $this->assertEquals('foobar', $cache->get('foo'));

        $cache->delete('foo');
        $this->assertEquals(null, $cache->get('foo'));

        $cache->setMultiple(['foo' => 'bar', 'baz' => 'bat']);
        $this->assertEquals('bar', $cache->get('foo'));
        $this->assertEquals('bat', $cache->get('baz'));

        $cache->deleteMultiple(['foo', 'baz']);
        $this->assertEquals(null, $cache->get('foo'));
        $this->assertEquals(null, $cache->get('baz'));

        $cache->set('foo', 'foobar');
        $this->assertEquals('foobar', $cache->get('foo'));

        $cache->clear();
        $this->assertEquals(null, $cache->get('foo'));
    }

    public function generateInstances()
    {
        yield [$this->createCache()];
        yield [new CacheFallback(new ErrorAdapter(), $this->createCache())];
        yield [new CacheFallback(new ErrorAdapter(), new ErrorAdapter(), $this->createCache())];
        yield [new CacheFallback(new ErrorAdapter(), new ErrorAdapter(), new ErrorAdapter(), $this->createCache())];
    }

    private function createCache()
    {
        $arrayCache = new ArrayCachePool();
        $arrayCache->set('foo', 'bar');

        return $arrayCache;
    }


}
