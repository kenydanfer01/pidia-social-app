<?php

namespace SocialApp\Apps\Financiero\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Financiero\Webapp\Repository\SocioRepository;
use Symfony\Bundle\SecurityBundle\Security;
class SocioManager extends CRUDManager
{
    public function __construct(SocioRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
