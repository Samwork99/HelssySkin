<?php

namespace App\Service\Cart;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductsRepository;

class CartService {

    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductsRepository $productRepository) 
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    // Pour ajouter un produit
    public function add(int $id) 
    {
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $this->session->set('panier', $panier);
    }

    // Pour vider le panier
    // public function clear() 
    // {
    //     $panier = $this->session->get('panier');

    //     if(!empty($panier[$id])) {
    //         unset($panier[$id]);
    //     }

    //     $this->session->set('panier', $panier);
    // }

    // Pour supprimer un produit
    public function remove(int $id) 
    {
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }

    // Pour obtenir le panier complet
    public function getFullCart(): array
    {
        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach($panier as $id => $quantity) 
        {
            $panierWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $panierWithData;
    }

    // Pour obtenir le montant total du panier
    public function getTotal() : float 
    {
        $total = 0;

        foreach($this->getFullCart() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }
}