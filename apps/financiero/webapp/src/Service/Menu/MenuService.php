<?php

declare(strict_types=1);

namespace SocialApp\Apps\Financiero\Webapp\Service\Menu;

use CarlosChininin\App\Domain\Model\AuthMenu\MenuServiceInterface;
use SocialApp\Apps\Financiero\Webapp\Repository\MenuRepository;

final class MenuService implements MenuServiceInterface
{
    public function __construct(private readonly MenuRepository $menuRepository)
    {
    }

    public function menusToArray(): array
    {
        $menus = $this->menuRepository->allForMenus();
        $data = [];
        foreach ($menus as $menu) {
            $name = mb_strtoupper($menu['parentName'].' - '.$menu['name']);
            $data[$name] = $menu['route'];
        }

        return $data;
    }
}
