<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage\Exception;

final class CacheStorageException extends \RuntimeException
{
    public function __construct(\Throwable $previous)
    {
        parent::__construct(
            sprintf('Cache operation failed: %s', $previous->getMessage()),
            0,
            $previous
        );
    }
}
