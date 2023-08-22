<?php

namespace SocialApp\Apps\Salud\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Salud\Webapp\Repository\FichaExamenAuxiliarRepository;
use Symfony\Bundle\SecurityBundle\Security;

class FichaExamenAuxiliarManager extends CRUDManager
{
    public function __construct(FichaExamenAuxiliarRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
