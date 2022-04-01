<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $article = new  Article();
            $article->setTitle($faker->text(15));
            $article->setMessage($faker->text);

            for ($u = 0; $u < 3; $u++) {
                $comment = new Comment();
                $comment->setTitle($faker->name);
                $comment->setMessage($faker->text);
                $comment->setArticle($article);
                $manager->persist($comment);
            }
            $manager->persist($article);
        }
        $manager->flush();
    }
}
