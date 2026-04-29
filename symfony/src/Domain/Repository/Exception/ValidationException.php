<?php

declare(strict_types=1);

namespace App\Domain\Repository\Exception;

final class ValidationException extends \RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct('Validation failed: ' . $message);
    }
}
