<?php

namespace SocialApp\Apps\Financiero\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Financiero\Webapp\Repository\ProyeccionRepository;
use Symfony\Bundle\SecurityBundle\Security;
class ProyeccionManager extends CRUDManager
{
    public function __construct(ProyeccionRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
