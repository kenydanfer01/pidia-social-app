<?php

namespace SocialApp\Apps\Salud\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Salud\Webapp\Repository\BeneficiarioRepository;
use Symfony\Bundle\SecurityBundle\Security;

class BeneficiarioManager extends CRUDManager
{
    public function __construct(BeneficiarioRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
