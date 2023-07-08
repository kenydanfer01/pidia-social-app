<?php

namespace SocialApp\Apps\Salud\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Salud\Webapp\Repository\FichaEvaluacionRepository;
use Symfony\Bundle\SecurityBundle\Security;

class FichaEvaluacionManager extends CRUDManager
{
    public function __construct(FichaEvaluacionRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
