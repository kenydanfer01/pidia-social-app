<?php

namespace SocialApp\Apps\Financiero\Webapp\Manager;
use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Financiero\Webapp\Repository\TipoCreditoRepository;
use Symfony\Bundle\SecurityBundle\Security;

class TipoCreditoManager extends CRUDManager
{
    public function __construct(TipoCreditoRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
