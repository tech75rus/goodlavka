<?php

namespace App\DataFixtures;

use App\Entity\Shop\Token;
use App\Entity\Shop\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('DmitryX');
        $user1->setEmail('tech76@mail.ru');
        $user1->setPassword(password_hash('123456', PASSWORD_ARGON2I));
        $user1->setRoles(["ROLE_ADMIN"]);

        for ($i = 0; $i < 3; $i++) {
            $token = new Token();
            $token->setUser($user1);
            $token->setExpiresAt(new \DateTime());
            $token->setToken(bin2hex(random_bytes(60)));
            $manager->persist($token);
        }

        $user2 = new User();
        $user2->setUsername('Alexander');
        $user2->setEmail('tech77@mail.ru');
        $user2->setPassword(password_hash('123456', PASSWORD_ARGON2I));
        $user2->setRoles([]);

        for ($i = 0; $i < 3; $i++) {
            $token = new Token();
            $token->setUser($user2);
            $token->setExpiresAt(new \DateTime());
            $token->setToken(bin2hex(random_bytes(60)));
            $manager->persist($token);
        }

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();
    }
}
