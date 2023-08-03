<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Financiero\Webapp\Repository\ConfigMenuRepository;
use Symfony\Bundle\SecurityBundle\Security;

final class ConfigMenuManager extends CRUDManager
{
    public function __construct(ConfigMenuRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
