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
    #[Route('/', name: 'app_products_index', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        $category = $doctrine->getRepository(Products::class)->findAll();
        $products = $category->getCategory();
        return $this->render('products/index.html.twig', [
            'products' => $productsRepository->findBy( ['name'=>'Visage'], ['name'=>'DESC'] ),
        ]);
    }

//     // ----------------------------------------------------------------------------------------------
    
//     // #[Route('/soins/visage', name: 'app_soins_visage')]
//     // public function soins_visage(ProductRepository $productRepository): Response
//     // { 

//     //     // Récupérer tous mes produits "Visage" en BDD
//     //     $products = $productRepository->findBy(
//     //         ['type' => 'visage'],
//     //     );

//     //     // Second paramètre :
//     //     return $this->render('soins_visage/index.html.twig', [
//     //         'controller_name' => 'ProductsController',
//     //         'products' => $products,
//     //     ]);
//     // }
    
//     // #[Route('/soins/corps', name: 'app_soins_corps')]
//     // public function soins_corps(ProductRepository $productRepository)
//     // {
//     //     // Récupérer tous mes produits "Corps" en BDD
//     //     $products = $productRepository->findBy(
//     //         ['type'=> 'corps'],
//     //     );
//     //     dd($products);
//     //     die("ok");
//     //     // Le second paramètre de la fonction render est un tableau contenant 
//     //     // les différentes variables que l'on souhaite transmettre au front
//     // }

//     // -------------------------------------------------------------------------------

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

    #[Route('/{id}', name: 'app_products_show', methods: ['GET'])]
    public function show(Products $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
        ]);
    }

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

    #[Route('/{id}', name: 'app_products_delete', methods: ['POST'])]
    public function delete(Request $request, Products $product, ProductsRepository $productsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productsRepository->remove($product);
        }

        return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
    }
}
