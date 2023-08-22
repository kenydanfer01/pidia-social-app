<?php

namespace SocialApp\Apps\Salud\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Salud\Webapp\Repository\ExamenAuxiliarRepository;
use Symfony\Bundle\SecurityBundle\Security;

class ExamenAuxiliarManager extends CRUDManager
{
    public function __construct(ExamenAuxiliarRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
