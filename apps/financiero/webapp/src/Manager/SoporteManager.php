<?php

namespace SocialApp\Apps\Financiero\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Financiero\Webapp\Repository\SoporteRepository;
use Symfony\Bundle\SecurityBundle\Security;
class SoporteManager extends CRUDManager
{
    public function __construct(SoporteRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
