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

#[Route('/shop')]
class ShopController extends AbstractController
{
    #[Route('/', name: 'shop_index', methods: ['GET', 'POST'])]
    public function index(ShopRepository $shopRepository, Request $request): Response
    {
        $form = $this->createForm(AddressType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $client = HttpClient::create();
            $response = $client->request(
                'GET',
                'http://api.positionstack.com/v1/forward',
                [
                    'query' => [
                        'access_key' => $this->getParameter('app.positionstack_api_key'),
                        'query' => $data["address"],
                    ]
                ],
            );

            $responseData = $response->toArray()["data"][0];
            $shops = $shopRepository->findAll();
            foreach ($shops as $key => &$shop) {
                $distance = round($this->distance($shop->getLatitude(), $shop->getLongitude(), $responseData["latitude"], $responseData["longitude"]), 0);

                if ($distance > 50000) {
                    unset($shops[$key]);
                }

                $distance = ($distance >= 1000 ? (round(($distance / 1000), 0) . "Km") : ($distance . "m"));
                $shop->distance = $distance;
            }

            //TODO: fetch products in search

            return $this->render('shop/index.html.twig', [
                'shops' => $shops,
                'proximity' => true,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('shop/index.html.twig', [
            'shops' => $shopRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'shop_view', methods: ['GET'])]
    public function view(Shop $shop): Response
    {
        return $this->render('shop/view.html.twig', [
            'shop' => $shop,
            'products' => $shop->getProducts(),
        ]);
    }

    #[Route('/{id}', name: 'shop_contact', methods: ['POST'])]
    public function contact(Shop $shop): Response
    {
        dd("true");

//        return $this->render('shop/view.html.twig', [
//            'shop' => $shop,
//            'products' => $shop->getProducts(),
//        ]);
    }

    #[Route('/{adress}', name: 'shop_adress', methods: ['GET'])]
    public function adress(ShopRepository $shopRepository): Response
    {
        dd($this->get("adress"));

//        return $this->render('shop/view.html.twig', [
//            'shop' => $shop,
//            'products' => $shop->getProducts(),
//        ]);
    }

    private function distance($lat1, $lng1, $lat2, $lng2) {
        $earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
        $rlo1 = deg2rad($lng1);
        $rla1 = deg2rad($lat1);
        $rlo2 = deg2rad($lng2);
        $rla2 = deg2rad($lat2);
        $dlo = ($rlo2 - $rlo1) / 2;
        $dla = ($rla2 - $rla1) / 2;
        $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo));
        $d = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return ($earth_radius * $d);
    }
}
