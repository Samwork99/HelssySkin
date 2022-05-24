<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CguCgvController extends AbstractController {

    #[Route('/cgucgv', name: 'app_cgucgv')]

    public function index(): Response 
    {
       return $this->render('cgucgv.html.twig', [
        'controller_name' => 'CguCgvController',
       ]);
    }
}