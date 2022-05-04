<?php

namespace App\Security;

use App\Entity\Shop\Token;
use App\Repository\Shop\TokenRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class UserAuthenticator extends AbstractAuthenticator
{
    private TokenRepository $tokenRepository;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('shop-token');
    }

    public function authenticate(Request $request): Passport
    {
        $header = $request->headers->get('shop-token');
        /** @var Token $token */
        $token = $this->tokenRepository->findOneBy(['token' => $header]);
        $user = $token->getUser();
        $uuid = $user->getUuid();
        return new SelfValidatingPassport(new UserBadge($uuid));

// examples custom authentication
//        $password = '1234567';
//        return new Passport(
//            new UserBadge('gladkix'),
//            new PasswordCredentials($password)
//        );
//        return new Passport(
//            new UserBadge('gladkix'),
//            new CustomCredentials(function () {
//                return true;
//            }, $password)
//        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response($exception->getMessage(), 401);
    }
}
