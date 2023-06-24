<?php

declare(strict_types=1);

namespace SocialApp\Security\UserLogin\Infrastructure\Security;

use SocialApp\Security\UserStore\Domain\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function refreshUser(UserInterface $user): UserInterface|User
    {
//        if (!$user instanceof User) {
//            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
//        }

        return $user; // Return a User object after making sure its data is "fresh".
    }

    public function supportsClass(string $class): bool
    {
        return is_subclass_of($class, UserInterface::class);
//        return User::class === $class || is_subclass_of($class, User::class);
    }

    public function loadUserByIdentifier(string $identifier): User
    {
        return $this->entityManager->createQuery('
                SELECT user
                FROM SocialApp\Security\UserStore\Domain\Model\User user
                WHERE user.name.value = :identifier
            ')
            ->setParameter('identifier', $identifier)
            ->getOneOrNullResult();
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        // TODO: when hashed passwords are in use, this method should:
        // 1. persist the new password in the user storage
        // 2. update the $user object with $user->setPassword($newHashedPassword);
    }
}
