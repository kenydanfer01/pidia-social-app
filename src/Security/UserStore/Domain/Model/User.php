<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Security\UserStore\Domain\Model;

use SocialApp\Security\UserStore\Domain\ValueObject\UserFullName;
use SocialApp\Security\UserStore\Domain\ValueObject\UserId;
use SocialApp\Security\UserStore\Domain\ValueObject\UserIsActive;
use SocialApp\Security\UserStore\Domain\ValueObject\UserName;
use SocialApp\Security\UserStore\Domain\ValueObject\UserPassword;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Embedded(columnPrefix: false)]
    private readonly UserId $id;

    #[ORM\Embedded(columnPrefix: false)]
    private readonly UserIsActive $isActive;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private UserName $name,

        #[ORM\Embedded(columnPrefix: false)]
        private UserPassword $password,

        #[ORM\Embedded(columnPrefix: false)]
        private UserFullName $fullName,
    ) {
        $this->id = new UserId();
        $this->isActive = new UserIsActive();
    }

    public function update(
        ?UserName $name = null,
        ?UserPassword $password = null,
        ?UserFullName $fullName = null,
    ): void {
        $this->name = $name ?? $this->name;
        $this->password = $password ?? $this->password;
        $this->fullName = $fullName ?? $this->fullName;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public function updatePassword(UserPassword $password): void
    {
        $this->password = $password;
    }

    public function fullName(): UserFullName
    {
        return $this->fullName;
    }

    public function isActive(): UserIsActive
    {
        return $this->isActive;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = []; // $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

//    public function setRoles(array $roles): self
//    {
//        $this->roles = $roles;
//
//        return $this;
//    }

    public function eraseCredentials()
    {
        // not needed when using the "auto" algorithm in security.yaml
    }

    public function getUserIdentifier(): string
    {
        return $this->name()->value;
    }

    public function getPassword(): ?string
    {
        return $this->password()->value;
    }
}
