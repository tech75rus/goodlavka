<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\ProductsCart;
use App\Entity\Shop\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    /** @var ?User $user */
    private ?User $user;
    private ?Cart $cart;

    public function __construct(EntityManagerInterface $entityManager)
    {
//        $this->user = $this->getUser();
//        $this->cart = $this->user->getCart();
        $this->entityManager = $entityManager;
    }

    #[Route('/test', name: 'test')]
    public function index(): Response
    {
        return new Response('test');
    }

    #[Route('/test/create-cart')]
    public function createCart(): ?Response
    {
        /** @var Cart $cart */
        $cart = $this->getUser()->getCart();
        $cart->setPrice(rand(50, 1000) . '.' . rand(1, 99));
        $cart->setIsEmpty(false);

        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $this->json('created cart');
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
    public function addProduct($id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);
        $price = $product->getPrice();
        /** @var Cart $cart */
        $cart = $this->getUser()->getCart();

        $cart->setPrice(12.12);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return new Response('added product ' .$id);
    }

    #[Route('/test/clear-cart')]
    public function clearCart(): ?Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $cart = $user->getCart();
        $cart->clearCart();
        $this->entityManager->flush();
        return new Response('Cart clear');
    }

    #[Route('/shop/cart-show')]
    #[IsGranted('ROLE_GUEST')]
    public function deleteUser(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $cart = $user->getCart();
        return $this->json('here products cart');
    }
}
