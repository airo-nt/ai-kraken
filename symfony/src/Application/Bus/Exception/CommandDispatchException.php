<?php

declare(strict_types=1);

namespace App\Application\Bus\Exception;

final class CommandDispatchException extends \RuntimeException
{
    public static function fromPrevious(\Throwable $previous): self
    {
        return new self(
            sprintf('Failed to dispatch command: %s', $previous->getMessage()),
            0,
            $previous
        );
    }
}
