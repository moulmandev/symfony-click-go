<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\AddressType;
use App\Form\ShopType;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_cart', methods: ['GET'])]
    public function cart(ShopRepository $shopRepository): Response
    {
        dd("true");
    }

}
