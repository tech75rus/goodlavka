<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    public ?string $roles = '';

    #[Route('/main', name: 'main')]
    public function main(Request $request): Response
    {
        $this->roles = json_encode($this->getUser()->getRoles());
        return new Response('main ' . $this->roles);
    }

    #[Route('/about', name: 'about')]
    public function about(): ?Response
    {
        $this->getUser()->getUsername();
        return new Response('about');
    }
}
