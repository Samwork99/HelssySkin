<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SoinsCorpsController extends AbstractController
{
    #[Route('/soins/corps', name: 'app_soins_corps')]
    public function index(): Response
    {
        return $this->render('soins_corps/index.html.twig', [
            'controller_name' => 'SoinsCorpsController',
        ]);
    }
}
