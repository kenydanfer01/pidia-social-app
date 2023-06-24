<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Security\UserStore\Application\Command;

use SocialApp\Security\UserStore\Domain\Exception\MissingUserException;
use SocialApp\Security\UserStore\Domain\Model\User;
use SocialApp\Security\UserStore\Domain\Repository\UserRepositoryInterface;
use SocialApp\Security\UserStore\Domain\ValueObject\UserPassword;
use SocialApp\Shared\Application\Command\CommandHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(UpdateUserCommand $command): User
    {
        $user = $this->userRepository->ofId($command->id);
        if (null === $user) {
            throw new MissingUserException($command->id);
        }

        if (null !== ($password = $command->password)) {
            $passwordEncrypted = $this->passwordHasher->hashPassword($user, $password->value);
            $password = new UserPassword($passwordEncrypted);
        }

        $user->update(
            name: $command->name,
            password: $password,
            fullName: $command->fullName,
        );

        $this->userRepository->save($user);

        return $user;
    }
}
