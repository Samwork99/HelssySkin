<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Pour afficher mes produits :
#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart')]
    public function index(CartService $cartService)
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
    ]);
}

    // Pour ajouter un produit :
    #[Route('/add/{id}', name: 'cart_add')]
    public function add($id, CartService $cartService) 
    {
       $cartService->add($id);

        return $this->redirectToRoute("app_cart");
    }

    // Pour supprimer un produit : 
    #[Route('/remove/{id}', name: 'cart_remove')]
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);

        return $this->redirectToRoute("app_cart");
    }

    // Pour vider le panier :
    // #[Route('/clear', name: 'cart_clear')]
    // public function clear(CartService $cartService)
    // {
    //    $cartService->clear;

    //     return $this->redirectToRoute("app_cart");
    // }
}

