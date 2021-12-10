<?php

namespace App\Controller;

use App\Entity\Command;
use App\Repository\CommandRepository;
use App\Repository\ProductRepository;
use App\Repository\ReservationRepository;
use App\Repository\ShopRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
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
    public function viewCart(UserRepository $userRepository, ShopRepository $shopRepository, ProductRepository $productRepository, ReservationRepository $reservationRepository, Request $request): Response
    {
        $user = $this->security->getUser();
        $userEntity = $userRepository->findOneBy(["email" => $user->getUserIdentifier()]);
        $slots = $reservationRepository->findAll();
        $shops = $shopRepository->findAll();

        $total = 0;
        foreach ($userEntity->getCart() as $product)
            $total += $product->getPrice();

        return $this->render('cart.html.twig', [
            "total" => $total,
            "slots" => $slots,
            "shops" => $shops,
        ]);
    }

    #[Route('/cart/valid', name: 'user_validCart', methods: ['POST'])]
    public function validCart(MailerInterface $mailer, Request $request, CommandRepository $commandRepository, ReservationRepository $reservationRepository, ShopRepository $shopRepository, UserRepository $userRepository): Response
    {
        $creneau_id = $request->request->get("creneau");
        $retrait_id = $request->request->get("retrait");

        if (!$creneau_id) {
            $this->addFlash('error', 'Vous devez choisir un créneau.');
            return $this->redirect($request->headers->get('referer'));
        }

        if (!$retrait_id) {
            $this->addFlash('error', 'Vous devez choisir un point de retrait.');
            return $this->redirect($request->headers->get('referer'));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $creneauEntity = $reservationRepository->find($creneau_id);
        $retraitEntity = $shopRepository->find($retrait_id);

        $user = $this->security->getUser();
        $userEntity = $userRepository->findOneBy(["email" => $user->getUserIdentifier()]);

        if (count($userEntity->getCart()) === 0) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirect($request->headers->get('referer'));
        }

        $command = new Command();
        $command->setUser($userEntity);
        $command->setReservation($creneauEntity);
        $command->setRetrait($retraitEntity);
        $command->setDelivered(false);

        $total = 0;
        foreach ($userEntity->getCart() as $product) {
            $total += $product->getPrice();

            if (($product->getQuantity() - 1) < 0) {
                $this->addFlash('error', 'Il n\'y a plus de stock pour le produit : \''.$product->getName().'\'');

                return $this->redirect($request->headers->get('referer'));
            }
            $product->setQuantity($product->getQuantity() - 1);
            $entityManager->persist($product);
            $entityManager->flush();

            $command->addProduct($product);
        }


        $entityManager->persist($command);
        $entityManager->flush();

        $email = (new TemplatedEmail())
            ->from('contact@moulmandev.fr')
            ->to($user->getUserIdentifier())
            ->subject('Validation de votre commande #'.$command->getId().' - Click&Go')
            ->htmlTemplate('emails/validation.html.twig')
            ->context([
                'id' => $command->getId(),
                'products' => $userEntity->getCart(),
                'total' => $total,
                'shop' => $retraitEntity,
                'creneau' => $creneauEntity
            ]);

        $mailer->send($email);

        // Clearing user cart
        $userEntity->clearCart();
        $entityManager->persist($userEntity);
        $entityManager->flush();

        $this->addFlash('success', 'Votre commande est validée, vous allez recevoir un mail récapitulant votre commande. Merci de votre confiance !');

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/commands', name: 'my_commands', methods: ['GET'])]
    public function myCommands(UserRepository $userRepository): Response
    {
        $user = $this->security->getUser();
        $userEntity = $userRepository->findOneBy(["email" => $user->getUserIdentifier()]);

        $commands = $userEntity->getCommands();

        return $this->render('commands.html.twig', [
            "commands" => $commands
        ]);
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
