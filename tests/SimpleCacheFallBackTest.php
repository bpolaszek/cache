<?php

namespace BenTools\Cache\Tests;

use BenTools\Cache\Fallback\CacheFallback;
use Cache\Adapter\PHPArray\ArrayCachePool;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;

final class SimpleCacheFallBackTest extends TestCase
{

    /**
     * @var CacheInterface
     */
    private $default;

    /**
     * @var CacheFallback
     */
    private $cache;

    protected function setUp()
    {
        $main = new ErrorAdapter();
        $this->default = new ArrayCachePool();
        $this->default->set('foo', 'bar');
        $this->cache = new CacheFallback($main, $this->default);
    }

    /**
     * @test
     */
    public function it_falls_back()
    {
        $this->assertInstanceOf(CacheFallback::class, $this->cache);
        $this->assertTrue($this->cache->has('foo'));
        $this->assertEquals('bar', $this->cache->get('foo'));

        $this->cache->set('foo', 'foobar');
        $this->assertEquals('foobar', $this->cache->get('foo'));

        $this->cache->delete('foo');
        $this->assertEquals(null, $this->cache->get('foo'));

        $this->cache->setMultiple(['foo' => 'bar', 'baz' => 'bat']);
        $this->assertEquals('bar', $this->cache->get('foo'));
        $this->assertEquals('bat', $this->cache->get('baz'));

        $this->cache->deleteMultiple(['foo', 'baz']);
        $this->assertEquals(null, $this->cache->get('foo'));
        $this->assertEquals(null, $this->cache->get('baz'));

        $this->cache->set('foo', 'foobar');
        $this->assertEquals('foobar', $this->cache->get('foo'));

        $this->cache->clear();
        $this->assertEquals(null, $this->cache->get('foo'));
    }



}
