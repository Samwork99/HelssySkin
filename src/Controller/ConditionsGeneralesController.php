<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/conditions/generales')]
class ConditionsGeneralesController extends AbstractController
{
    #[Route('/', name: 'app_conditions_generales')]
    public function index(): Response
    {
        return $this->render('conditions_generales/index.html.twig', [
            'controller_name' => 'ConditionsGeneralesController',
        ]);
    }

    #[Route('/cgucgv', name: 'app_cgucgv')]
    public function cgucgv(): Response 
    {
       return $this->render('conditions_generales/cgucgv.html.twig', [
        'controller_name' => 'ConditionsGeneralesController',
       ]);
    }

    #[Route('/rgpd', name: 'app_rgpd')]
    public function rgpd(): Response
    {
        return $this->render('conditions_generales/rgpd.html.twig', [
            'controller_name' => 'ConditionsGeneralesController',
        ]);
    }

    #[Route('/mentions/legales', name: 'app_mentions_legales')]
    public function mentionslegales(): Response
    {
        return $this->render('conditions_generales/mentions_legales.html.twig', [
            'controller_name' => 'ConditionsGeneralesController',
        ]);
    }
}
