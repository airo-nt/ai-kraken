<?php

declare(strict_types=1);

namespace App\Application\Repository\Exception;

use Throwable;

final class ReadRepositoryException extends \RuntimeException
{
    public function __construct(Throwable $previous)
    {
        parent::__construct('Read repository error: ' . $previous->getMessage(), 0, $previous);
    }
}
