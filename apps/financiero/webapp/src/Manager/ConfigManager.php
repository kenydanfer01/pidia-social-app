<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Financiero\Webapp\Repository\ConfigRepository;
use Symfony\Bundle\SecurityBundle\Security;

final class ConfigManager extends CRUDManager
{
    public function __construct(ConfigRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
