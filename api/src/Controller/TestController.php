<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function index(): Response
    {
        return new Response('test');
    }

    #[Route('/test/cart')]
    #[IsGranted('ROLE_ADMIN')]
    public function cart(EntityManagerInterface $entityManager): ?Response
    {
        dd($this->getUser()->getUserIdentifier());
        return new Response('Cart');
    }

    #[Route('/test/cart-update/{id}')]
    public function cartUpdate(EntityManagerInterface $em, CartRepository $cartRepository, $id): ?Response
    {
        $cart = $cartRepository->findAll();
        foreach ($cart as $item) {
            /** @var Cart $item */
            $price = rand(101, 200);
            $item->setPrice($price);
            $em->persist($item);
        }
        $em->flush();
        return new Response('Data update');
    }
}
