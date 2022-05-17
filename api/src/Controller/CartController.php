<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\ProductsCart;
use App\Entity\Shop\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/test/update-cart')]
    public function updateCart(EntityManagerInterface $em): ?Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $cart = $user->getCart();
        $cart->setPrice(rand(50, 1000) . '.' . rand(1, 999));
        $em->flush();
        return new Response('Data update');
    }

    #[Route('/shop/cart/add-product/{id}')]
    #[IsGranted('ROLE_GUEST')]
    public function addProduct(int $id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);
        if (!$product) {
            return $this->json('Don\'t product', 400);
        }
        /** @var User $user */
        $user = $this->getUser();
        /** @var Cart $cart */
        $cart = $user->getCart();
        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $cart->setIsEmpty(false);
            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        }
        /** @var ProductsCart $productsCart */
        $productsCart = $cart->getProductsCarts();

        $result = false;
        $k = 0;
        foreach ($productsCart as $key => $itemProduct) {
            if ($itemProduct->getProduct()->getId() === $id) {
                $result = true;
                $k = $key;
            }
        }
        if ($result) {
            /** @var ProductsCart $productCart */
            $productCart = $productsCart[$k];
            $productCart->setCount(1);
        } else {
            $newProductCart = new ProductsCart();
            $newProductCart->setCart($cart);
            $newProductCart->setProduct($product);
            $newProductCart->setCount(1);
            $this->entityManager->persist($newProductCart);
        }
        $cart->setUpdateAt();
        $this->entityManager->flush();

        return $this->json($product->getName(). ' added in cart', 201);
    }

    #[Route('/shop/cart-show')]
    #[IsGranted('ROLE_GUEST')]
    public function cartShow(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Cart $cart */
        $cart = $user->getCart();
        $productDetail = $cart->getProductsCarts();
        $cartPrice = '0';
        foreach ($productDetail as $product) {
            $price = bcmul($product->getProduct()->getPrice(),  (string)$product->getCount(), 2);
            $product->setPrice($price);
            $cartPrice = bcadd($cartPrice, $price, 2);
        }
        $cart->setPrice($cartPrice);
        return $this->json($cart, 201, [], [
            'groups' => 'shop'
        ]);
    }

    #[Route('/shop/cart/clear-cart')]
    #[IsGranted('ROLE_GUEST')]
    public function clearCart(): ?Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $cart = $user->getCart();
        $cart->clearCart();
        $this->entityManager->flush();
        return new Response('Cart clear');
    }

}
