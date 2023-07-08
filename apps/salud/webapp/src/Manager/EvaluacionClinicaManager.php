<?php

namespace SocialApp\Apps\Salud\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Salud\Webapp\Repository\EvaluacionClinicaRepository;
use Symfony\Bundle\SecurityBundle\Security;

class EvaluacionClinicaManager extends CRUDManager
{
    public function __construct(EvaluacionClinicaRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
