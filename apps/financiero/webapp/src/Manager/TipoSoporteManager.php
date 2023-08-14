<?php

namespace SocialApp\Apps\Financiero\Webapp\Manager;
use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Financiero\Webapp\Repository\TipoSoporteRepository;
use Symfony\Bundle\SecurityBundle\Security;

class TipoSoporteManager extends CRUDManager
{
    public function __construct(TipoSoporteRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
