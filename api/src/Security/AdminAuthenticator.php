<?php

namespace App\Security;

use App\Entity\Admin\AdminToken;
use App\Repository\Admin\AdminTokenRepository;
use App\Repository\TokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class AdminAuthenticator extends AbstractAuthenticator
{
    private AdminTokenRepository $adminTokenRepository;

    public function __construct(AdminTokenRepository $adminTokenRepository)
    {
        $this->adminTokenRepository = $adminTokenRepository;
    }

    public function supports(Request $request): ?bool
    {
        return !($request->headers->get('token') === null);
        //dd($request->headers->get('token'));
        //return $request->headers->get('token');
    }

    public function authenticate(Request $request): PassportInterface
    {
        $token = $request->headers->get('token');

        /** @var AdminToken $token */
        $token = $this->adminTokenRepository->findOneBy(['token' => $token]);
        if ($token === null) {
            throw new CustomUserMessageAuthenticationException('not token');
        }

        if ($token->isExpired()) {
            throw new CustomUserMessageAuthenticationException('token expired');
        }

        return new SelfValidatingPassport(new UserBadge($token->getAdminAdmin()->getUserIdentifier()));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        //return new JsonResponse($exception->getMessageKey(), 401); так безопаснее
        //return new JsonResponse($exception->getMessageData(), 401); и так
        return new JsonResponse($exception->getMessage(), 401);
    }
}
