<?php

namespace SocialApp\Apps\Financiero\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Financiero\Webapp\Repository\PagoRepository;
use Symfony\Bundle\SecurityBundle\Security;
class PagoManager extends CRUDManager
{
    public function __construct(PagoRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
