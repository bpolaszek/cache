[![Latest Stable Version](https://poser.pugx.org/bentools/cache/v/stable)](https://packagist.org/packages/bentools/cache)
[![License](https://poser.pugx.org/bentools/cache/license)](https://packagist.org/packages/bentools/cache)
[![Build Status](https://img.shields.io/travis/bpolaszek/cache/master.svg?style=flat-square)](https://travis-ci.org/bpolaszek/cache)
[![Coverage Status](https://coveralls.io/repos/github/bpolaszek/cache/badge.svg?branch=master)](https://coveralls.io/github/bpolaszek/cache?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/bpolaszek/cache.svg?style=flat-square)](https://scrutinizer-ci.com/g/bpolaszek/cache)
[![Total Downloads](https://poser.pugx.org/bentools/cache/downloads)](https://packagist.org/packages/bentools/cache)

# bentools/cache

## Usage

### Cache Fallback

If calling a cache method throws an exception, it will fall back to the other cache pool.

```php
use BenTools\Cache\Fallback\CacheFallback;
use Cache\Adapter\Memcache\MemcacheCachePool;
use Cache\Adapter\Redis\RedisCachePool;

$main = new RedisCachePool(new Redis());
$default = new MemcacheCachePool(new Memcache());
$cache = new CacheFallback($main, $default);
$cache->get('foo'); // if $main->get('foo') throws an exception, will call $default->get('foo')
```

## Installation

> composer require bentools/cache

## Tests

> ./vendor/bin/phpunit

## License

MIT.
