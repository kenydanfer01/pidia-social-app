<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Salud\Webapp\Repository\MenuRepository;
use Symfony\Bundle\SecurityBundle\Security;

final class MenuManager extends CRUDManager
{
    public function __construct(MenuRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
