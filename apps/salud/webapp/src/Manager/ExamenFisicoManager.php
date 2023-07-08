<?php

namespace SocialApp\Apps\Salud\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Salud\Webapp\Repository\ExamenFisicoRepository;
use Symfony\Bundle\SecurityBundle\Security;

class ExamenFisicoManager extends CRUDManager
{
    public function __construct(ExamenFisicoRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
