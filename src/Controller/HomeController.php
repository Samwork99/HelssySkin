<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/home')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

//     #[Route('/accueil', name: 'app_home_accueil')]
//     public function accueil(): Response
//     {
//         return $this->render('home/accueil.html.twig', [
//             'controller_name' => 'AccueilController',
//         ]);
//     }
}
