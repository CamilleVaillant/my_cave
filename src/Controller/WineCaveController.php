<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WineCaveController extends AbstractController{
    #[Route('/wine/cave', name: 'app_wine_cave')]
    public function index(): Response
    {
        return $this->render('wine_cave/index.html.twig', [
            'controller_name' => 'WineCaveController',
        ]);
    }
}
