<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FirstController extends AbstractController {

    #[Route('/first', name: 'app_first')]

    public function index(): Response 
    {
       return $this->render('first.html.twig', [
        'controller_name' => 'FirstController',
       ]);
    }
}

