<?php

namespace SocialApp\Apps\Demo\Webapp;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getCacheDir(): string
    {
        if (isset($_SERVER['DEMO_WEBAPP_VAR_DIR'])) {
            return \dirname(__DIR__).'/../../..'.$_SERVER['DEMO_WEBAPP_VAR_DIR'].'/'.$this->environment.'/cache';
        }

        return parent::getCacheDir();
    }

    public function getLogDir(): string
    {
        if (isset($_SERVER['DEMO_WEBAPP_VAR_DIR'])) {
            return \dirname(__DIR__).'/../../..'.$_SERVER['DEMO_WEBAPP_VAR_DIR'].'/'.$this->environment.'/log';
        }

        return parent::getLogDir();
    }
}
