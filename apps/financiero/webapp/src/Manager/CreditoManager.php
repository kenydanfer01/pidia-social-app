<?php

namespace SocialApp\Apps\Financiero\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Financiero\Webapp\Repository\CreditoRepository;
use Symfony\Bundle\SecurityBundle\Security;
class CreditoManager extends CRUDManager
{
    public function __construct(CreditoRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
