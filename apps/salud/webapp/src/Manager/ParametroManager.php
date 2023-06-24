<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Salud\Webapp\Repository\ParametroRepository;
use Symfony\Bundle\SecurityBundle\Security;

final class ParametroManager extends CRUDManager
{
    public function __construct(ParametroRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
