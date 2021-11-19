<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\ReservationRepository;
use App\Repository\ShopRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/user')]
class UserController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/cart', name: 'user_viewCart', methods: ['GET'])]
    public function viewCart(UserRepository $userRepository, ProductRepository $productRepository, ReservationRepository $reservationRepository, Request $request): Response
    {
        $user = $this->security->getUser();
        $userEntity = $userRepository->findOneBy(["email" => $user->getUserIdentifier()]);
        $slots = $reservationRepository->findAll();

        $total = 0;
        foreach ($userEntity->getCart() as $product)
            $total += $product->getPrice();

        return $this->render('cart.html.twig', [
            "total" => $total,
            "slots" => $slots,
        ]);
    }

    #[Route('/cart/valid', name: 'user_validCart', methods: ['POST'])]
    public function validCart(Request $request): Response
    {
        dd($request);
    }

    #[Route('/cart', name: 'user_cart', methods: ['POST'])]
    public function addCart(UserRepository $userRepository, ProductRepository $productRepository, Request $request): Response
    {
        $user = $this->security->getUser();
        if (!$user)
            return $this->redirectToRoute('app_login');

        $product_id = $request->request->get("product_id");
        $quantity = $request->request->get("quantity");

        $productEntity = $productRepository->find($product_id);

        $userEntity = $userRepository->findOneBy(["email" => $user->getUserIdentifier()]);
        for ($i = 0; $i < $quantity; $i++)
            $userEntity->addCart($productEntity);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($userEntity);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/cart/remove', name: 'user_removeCart', methods: ['POST'])]
    public function removeFromCart(UserRepository $userRepository, ProductRepository $productRepository, Request $request): Response
    {
        $user = $this->security->getUser();
        if (!$user)
            return $this->redirectToRoute('app_login');

        $product_id = $request->request->get("product_id");

        $productEntity = $productRepository->find($product_id);

        $userEntity = $userRepository->findOneBy(["email" => $user->getUserIdentifier()]);
        $userEntity->removeCart($productEntity);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($userEntity);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));
    }
}
