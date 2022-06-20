<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/shop/profile', methods: ['GET'])]
    #[IsGranted('ROLE_GUEST')]
    public function getProfileUser(): ?Response
    {
        return $this->json($this->getUser(), 201, [], [
            'groups' => 'profile'
        ]);
    }
}