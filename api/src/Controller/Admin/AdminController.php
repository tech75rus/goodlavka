<?php

namespace App\Controller\Admin;

use App\Entity\Admin\AdminToken;
use App\Entity\Shop\Token;
use App\Entity\Shop\User;
use App\Repository\Admin\AdminRepository;
use App\Repository\Shop\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private EntityManagerInterface $manager;
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private AdminRepository $adminRepository;

    public function __construct(
        EntityManagerInterface $manager,
        UserRepository $userRepository,
        AdminRepository $adminRepository,
        UserPasswordHasherInterface $passwordHasher
    )
    {
        $this->manager = $manager;
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->adminRepository = $adminRepository;
    }

    #[Route('/admin/registration', name: 'registration', methods: ['POST'])]
    public function registration(Request $request): Response
    {
        if (!$request->request->has('name') ||
            !$request->request->has('email') ||
            !$request->request->has('password'))
        {
            return new Response('Не хватает данных', 401);
        }

        $name = $request->request->get('name');
        $surname = $request->request->has('surname') ? $request->request->get('surname') : '';
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        if ($this->userRepository->findOneBy(['username' => $name]) !== null) {
            return new Response('Такой пользователь есть', 401);
        }
        if ($this->userRepository->findOneBy(['email' => $email]) !== null) {
            return new Response('Такой email есть', 401);
        }

        $user = new User();
        $user->setUsername($name);
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            $password
        ));

        $token = new Token();
        $token->setUser($user);

        $this->manager->persist($token);
        $this->manager->persist($user);
        $this->manager->flush();

        return new Response('Регистрация  успешна', 201, [
            'token' => $token->getToken()
        ]);
    }

    #[Route('/admin/login', name: 'login', methods: ['POST'])]
    public function login(Request $request): ?Response
    {
        if (!$request->request->has('name') ||
            !$request->request->has('password'))
        {
            return new Response('Не хватает данных', 401);
        }

        $name = $request->request->get('name');
        $password = $request->request->get('password');

        $admin = $this->adminRepository->findOneBy(['username' => $name]);
        //$user = $this->userRepository->findOneBy(['username' => $name]);
        if ($admin === null || !$this->passwordHasher->isPasswordValid($admin, $password)) {
            return new Response('Не верные данные', 401);
        }

        /*
         * удаление всех просроченных токенов
         */
        foreach ($admin->getAdminTokens() as $adminToken) {
            if ($adminToken->isExpired()) {
                $this->manager->remove($adminToken);
            }
        }

        /** @var AdminToken $token */
        $token = new AdminToken();
        $token->setAdminAdmin($admin);
        $this->manager->persist($token);
        $this->manager->flush();

        return new Response('Успех', 201, [
            'token' => $token->getToken()
        ]);
    }

    #[Route('/admin/main', methods: ['GET'])]
    public function main(): ?Response
    {
        //$mac = exec('getmac');
        return new Response('main');
    }

    #[Route('/admin/about', methods: ['GET'])]
    public function about(): ?Response
    {
        //$mac = exec('getmac');
        return new Response('about');
    }
}
