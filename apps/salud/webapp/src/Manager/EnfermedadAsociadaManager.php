<?php

namespace SocialApp\Apps\Salud\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Salud\Webapp\Repository\EnfermedadAsociadaRepository;
use Symfony\Bundle\SecurityBundle\Security;

class EnfermedadAsociadaManager extends CRUDManager
{
    public function __construct(EnfermedadAsociadaRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
