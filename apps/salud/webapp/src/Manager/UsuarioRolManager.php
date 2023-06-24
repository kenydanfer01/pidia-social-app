<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Salud\Webapp\Repository\UsuarioRolRepository;
use Symfony\Component\Security\Core\Security;

final class UsuarioRolManager extends CRUDManager
{
    public function __construct(UsuarioRolRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
