<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/products')]
class ProductsController extends AbstractController
{
    // Route de tous les produits
    #[Route('/', name: 'app_products_index', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        $products = $doctrine->getRepository(Products::class)->findAll();

        return $this->render('products/shop.html.twig', [
            'products' => $products
        ]);
    }
    // Route vers les poduits du visage
    #[Route('/visage', name: 'app_products_visage')]
    public function visage(ManagerRegistry $doctrine): Response
    {
        $category = $doctrine->getRepository(Products::class)->findBy(['category'=> 1]);

        return $this->render('products/index.html.twig', [
            'products' => $category
        ]);
    }
    // Route vers les produits du corps
    #[Route('/corps', name: 'app_products_corps')]
    public function corps(ManagerRegistry $doctrine): Response
    {
        $category = $doctrine->getRepository(Products::class)->findBy(['category'=> 2]);

        return $this->render('products/index.html.twig', [
            'products' => $category
        ]);
    }


    // Pour ajouter un nouveau produit
    #[Route('/new', name: 'app_products_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductsRepository $productsRepository): Response
    {
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productsRepository->add($product);
            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('products/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    // Pour accéder à la vue en détail du produit
    #[Route('/{id}', name: 'app_products_show', methods: ['GET'])]
    public function show(Products $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
        ]);
    }

    // Pour éditer le produit
    #[Route('/{id}/edit', name: 'app_products_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Products $product, ProductsRepository $productsRepository): Response
    {
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productsRepository->add($product);
            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->renderForm('products/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    // Pour supprimer les produits
    #[Route('/{id}', name: 'app_products_delete', methods: ['POST'])]
    public function delete(Request $request, Products $product, ProductsRepository $productsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productsRepository->remove($product);
        }

        return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
    }
}
