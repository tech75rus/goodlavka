<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for($i = 0; $i < 10; ++$i) {
            $product = new Product();
            $product->setName($faker->name);
            $product->setDescription($faker->realText(100));
            $product->setPrice($faker->randomFloat(2, 10, 999));
            $product->setImage(['/product/img'.$i.'.jpg']);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
