<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Salud\Webapp\Repository\PacienteRepository;
use Symfony\Bundle\SecurityBundle\Security;

class PacienteManager extends CRUDManager
{
    public function __construct(PacienteRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
