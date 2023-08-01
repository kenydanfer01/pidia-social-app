<?php

namespace SocialApp\Apps\Salud\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Salud\Webapp\Repository\RegistroFondosRepository;
use Symfony\Bundle\SecurityBundle\Security;

class RegistroFondosManager extends CRUDManager
{
    public function __construct(RegistroFondosRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
