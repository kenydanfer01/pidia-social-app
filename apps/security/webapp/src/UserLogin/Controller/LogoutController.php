<?php

declare(strict_types=1);

namespace SocialApp\Apps\Security\Webapp\UserLogin\Controller;

use Symfony\Component\Routing\Annotation\Route;

final class LogoutController
{
    #[Route('/logout', name: 'security_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
