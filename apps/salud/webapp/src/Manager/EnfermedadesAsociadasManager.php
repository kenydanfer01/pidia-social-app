<?php

namespace SocialApp\Apps\Salud\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Salud\Webapp\Repository\EnfermedadesAsociadasRepository;
use Symfony\Bundle\SecurityBundle\Security;

class EnfermedadesAsociadasManager extends CRUDManager
{
    public function __construct(EnfermedadesAsociadasRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
