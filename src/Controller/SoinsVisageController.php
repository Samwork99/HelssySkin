<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SoinsVisageController extends AbstractController
{
    #[Route('/soins/visage', name: 'app_soins_visage')]
    public function index(): Response
    { 
        
        return $this->render('soins_visage/index.html.twig', [
            'controller_name' => 'SoinsVisageController',
        ]);
    }
}
