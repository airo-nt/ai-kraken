<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage;

use App\Infrastructure\Storage\Exception\CacheStorageException;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

final class BotTelegramLastUpdateIdStorage
{
    private const string CACHE_KEY = 'bot_telegram.last_update_id';

    public function __construct(
        private readonly CacheInterface $cache,
        private readonly LoggerInterface $logger
    ) {}

    public function get(): int
    {
        try {
            return $this->cache->get(self::CACHE_KEY, fn() => 0);
        } catch (InvalidArgumentException $e) {
            $this->logger->error('Read cache failed', [
                'cache_key' => self::CACHE_KEY,
                'error' => $e->getMessage()
            ]);

            throw new CacheStorageException($e);
        }
    }

    public function set(int $lastUpdateId): void
    {
        try {
            $this->cache->delete(self::CACHE_KEY);
            $this->cache->get(self::CACHE_KEY, fn() => $lastUpdateId);
        } catch (InvalidArgumentException $e) {
            $this->logger->error('Write cache failed', [
                'cache_key' => self::CACHE_KEY,
                'error' => $e->getMessage()
            ]);

            throw new CacheStorageException($e);
        }
    }
}
