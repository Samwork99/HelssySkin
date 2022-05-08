<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Form\OrdersType;
use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/orders')]
class OrdersController extends AbstractController
{
    #[Route('/', name: 'app_orders_index', methods: ['GET'])]
    public function index(OrdersRepository $ordersRepository): Response
    {
        return $this->render('orders/index.html.twig', [
            'orders' => $ordersRepository->findAll(),
        ]);
    }

    // ----------------------------------------------------------------------------
    // Créer une nouvelle route qui va permettre de diriger le client vers le produit ajouté
    #[Route('/new_order/{id_product}', name: 'app_orders_new', methods: 'POST')]
    public function new_order(OrdersRepository $orderRepository, Products $id_product): Response
{	
    // Récupérer l'id du current user (le user est obligé d'être connecté)
    $current_user = $this->getUser();

		if($current_user) {
            // Récupérer la dernière commande en pending et non payé
			$pending_order = $orderRepository->findBy(
                ['user_id' => $current_user->getId()],
                ['pending' => '1'],
                ['paiement' => '0']
        );

        $entityManager = $doctrine->getManager();

        // Si l'objet "$pending_order" est null cela signifie qu'il n'existe pas et donc qu'il faut le créer
			if($pending_order) {

        // On lui ajoute un produit à cette commande
        $order_product = new OrderProduct();
        $order_product->setIdOrder($pending_order->getId());
        $order_product->setIdProduct($id_product);

        $entityManager->persist($order_product);
        $entityManager->flush();

        } else {
					
        // Création d'une nouvelle commande
        $order = new Order();
        $order->setIdUser($current_user->getId());
        $order->setPending('1');
        $order->setPaiement('O');
// ...       Ajouter tous les attributs qu'il faut
        $order->setFail('0');
        $order->setTotal();
        $order->setUserId();
        $order->createdAt();
        $order->updatedAt();
        
        $entityManager->persist($order_product);
        $entityManager->flush();	
        
        // On return sur la même route pour qu'il récupère la commande et ajoute le nouveau produit
        return $this->redirectToRoute('app_orders_new', ['id_product' => $id_product], 200);

        }

		} else {
        // Rediriger le client vers la page de connexion
		  return $this->redirectToRoute('app_login', [], 301);
		}

    // -------------------------------------------------------------------

    // }
    // #[Route('/new', name: 'app_orders_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, OrdersRepository $ordersRepository): Response
    // {
        
        // $order = new Orders();
        // $form = $this->createForm(OrdersType::class, $order);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $ordersRepository->add($order);
        //     return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
        // }

        // return $this->renderForm('orders/new.html.twig', [
        //     'order' => $order,
        //     'form' => $form,
        // ]);
        }
        
    #[Route('/{id}', name: 'app_orders_show', methods: ['GET'])]
    public function show(Orders $order): Response
    {
        return $this->render('orders/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_orders_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Orders $order, OrdersRepository $ordersRepository): Response
    {
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ordersRepository->add($order);
            return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orders/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orders_delete', methods: ['POST'])]
    public function delete(Request $request, Orders $order, OrdersRepository $ordersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $ordersRepository->remove($order);
        }

        return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
    }
}
