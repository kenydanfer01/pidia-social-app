<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Application\Command;

use SocialApp\Security\UserStore\Domain\Repository\UserRepositoryInterface;
use SocialApp\Shared\Application\Command\CommandHandlerInterface;

final class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        if (null === $user = $this->userRepository->ofId($command->id)) {
            return;
        }

        $this->userRepository->remove($user);
    }
}
