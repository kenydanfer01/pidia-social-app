<?php

declare(strict_types=1);

namespace SocialApp\Apps\Security\Webapp\Home\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('home/home.html.twig', []);
    }
}
