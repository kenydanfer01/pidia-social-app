<?php

declare(strict_types=1);

namespace SocialApp\Shared\Application\Command;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): mixed;
}
