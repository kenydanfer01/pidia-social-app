<?php

namespace SocialApp\Apps\Financiero\Webapp\Manager;

use CarlosChininin\App\Infrastructure\Manager\CRUDManager;
use SocialApp\Apps\Financiero\Webapp\Repository\BaseSocialRepository;
use Symfony\Bundle\SecurityBundle\Security;

final class BaseSocialManager extends CRUDManager
{
    public function __construct(BaseSocialRepository $repository, Security $security)
    {
        parent::__construct($repository, $security);
    }
}
