<?php

declare(strict_types=1);

namespace App\Application\Presentation;

interface ArrayableInterface
{
    public function toArray(): array;
}
