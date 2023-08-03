<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use SocialApp\Apps\Financiero\Webapp\Entity\Config;
use SocialApp\Apps\Financiero\Webapp\Entity\ConfigMenu;
use SocialApp\Apps\Financiero\Webapp\Entity\Menu;
use SocialApp\Apps\Financiero\Webapp\Entity\Usuario;
use SocialApp\Apps\Financiero\Webapp\Entity\UsuarioRol;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager)
    {
        $rol = new UsuarioRol();
        $rol->setName('Super Admin');
        $rol->setRol('ROLE_SUPER_ADMIN');
        $manager->persist($rol);

        $user = new Usuario();
        $user->setFullName('Super');
        $user->setUsername('admin');
        $user->setEmail('admin@admin.pe');
        $user->addUsuarioRole($rol);
        $encodedPassword = $this->passwordHasher->hashPassword($user, '123456');
        $user->setPassword($encodedPassword);
        $manager->persist($user);

        $config = new Config();
        $config->setAlias('default');
        $config->setNombre('Default company');
        $config->setOwner($user);
        $data = [
            'config_index' => 'Configuración',
            'menu_index' => 'Menus',
            'usuario_index' => 'Usuarios',
            'usuario_rol_index' => 'Usuario Roles',
            'parametro_index' => 'Parametro',
        ];

        foreach ($data as $key => $value) {
            $configMenu = new ConfigMenu();
            $configMenu->setName($value);
            $configMenu->setRoute($key);
            $manager->persist($configMenu);
            $config->addMenu($configMenu);
        }
        $manager->persist($config);

        $rol->setConfig($config);
        $rol->setOwner($user);
        $manager->persist($rol);

        $user->setOwner($user);
        $user->setConfig($config);
        $manager->persist($user);

        $menuPadre = new Menu();
        $menuPadre->setName('SEGURIDAD');
        $menuPadre->setIcon('bi bi-gear');
        $menuPadre->setOwner($user);
        $menuPadre->setConfig($config);
        $manager->persist($menuPadre);

        foreach ($data as $key => $value) {
            $menu = new Menu();
            $menu->setName($value);
            $menu->setRoute($key);
            $menu->setRanking(0);
            $menu->setParent($menuPadre);
            $menu->setOwner($user);
            $menu->setConfig($config);
            $manager->persist($menu);
        }

        $manager->flush();
    }
}
