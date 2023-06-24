<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Application\Command;

use SocialApp\Security\UserStore\Domain\Model\User;
use SocialApp\Security\UserStore\Domain\Repository\UserRepositoryInterface;
use SocialApp\Security\UserStore\Domain\ValueObject\UserPassword;
use SocialApp\Shared\Application\Command\CommandHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(CreateUserCommand $command): User
    {
        $user = new User(
            $command->name,
            $command->password,
            $command->fullName,
        );

        $password = $this->passwordHasher->hashPassword($user, $command->password->value);
        $user->updatePassword(new UserPassword($password));

        $this->userRepository->save($user);

        return $user;
    }
}
