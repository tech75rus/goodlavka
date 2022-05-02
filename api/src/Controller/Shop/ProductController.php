<?php

namespace App\Controller\Shop;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    #[Route('/test-product')]
    public function getProducts(): Response
    {
        /** @var $product Product */
        $product = $this->productRepository->findOneBy(['name' => 'test']);
        $products = $this->productRepository->findAll();
        return $this->json($products, 201, [
            'test-bla' => 'alksjd73728'
        ], [
                'groups' => 'admin'
            ]
        );

//        dd($products, 'name -> '.$name, 'price -> '.$price);
//        return $this->json('Product');
//        return new Response('Products');
    }
}
