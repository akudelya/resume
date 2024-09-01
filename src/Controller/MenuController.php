<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{
    #[Route('/', name: 'menu')]
    public function menu(): Response
    {
        return $this->render('menu.html.twig');
    }
}