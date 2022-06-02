<?php

namespace App\Controller\Shop;

use App\Entity\Cart;
use App\Entity\Shop\Token;
use App\Entity\Shop\User;
use App\Repository\Shop\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class AuthenticationController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private TokenRepository $tokenRepository;

    public function __construct(EntityManagerInterface $entityManager, TokenRepository $tokenRepository)
    {
        $this->entityManager = $entityManager;
        $this->tokenRepository = $tokenRepository;
    }

    #[Route('/register-guest')]
    public function registerGuest(): ?Response
    {
        $guest = new User();
        $token = new Token();
        $cart = new Cart();
        $uuid = Uuid::fromString($guest->getUuid());
        $guest->setUsername('GUEST_' .$uuid->toBase58());
        $token->setUser($guest);
        $cart->setUser($guest);
        $cart->setIsEmpty(1);
        $this->entityManager->persist($cart);
        $this->entityManager->persist($guest);
        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return new Response('Гость зарегистрирован', 201, [
            'shop-token' => $token->getToken()
        ]);
    }

    #[Route('/check-token')]
    public function checkToken(Request $request): Response
    {
        $token = $request->headers->get('shop-token');
        if ($this->tokenRepository->findOneBy(['token' => $token])) {
            return new Response('Токен есть');
        }
        return new Response('Токен не верен', Response::HTTP_UNAUTHORIZED);
    }

    #[Route('/test')]
    public function test(): ?Response
    {
        return new Response('test');
    }
}
