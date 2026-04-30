<?php

declare(strict_types=1);

namespace App\Application\Bus;

use App\Application\Bus\Exception\CommandDispatchException;

interface CommandBusInterface
{
    /* @throws CommandDispatchException */
    public function dispatch(object $command): void;
}
