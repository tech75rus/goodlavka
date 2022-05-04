<?php

namespace App\Controller\Shop;

use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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

    #[Route('/shop/products')]
    #[IsGranted('ROLE_GUEST')]
    public function getProducts(): Response
    {
        $products = $this->productRepository->findAll();
        return $this->json($products);

//        dd($products, 'name -> '.$name, 'price -> '.$price);
//        return $this->json('Product');
//        return new Response('Products');
    }

    #[Route('/shop/product/{id}')]
    #[IsGranted('ROLE_GUEST')]
    public function getProduct($id): Response
    {
        $product = $this->productRepository->findOneBy(['id' => $id]);
        return $this->json($product, 200, [], [
//            'groups' => 'shop'
        ]);
    }
}
